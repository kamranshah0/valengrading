<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FetchEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'helpdesk:fetch-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch incoming emails and attach them to contact queries';

    public function handle()
    {
        $this->info('Connecting to IMAP server...');

        // Fetch settings from .env
        $host = env('IMAP_HOST');
        $port = env('IMAP_PORT', 993);
        $encryption = env('IMAP_ENCRYPTION', 'ssl');
        $username = env('IMAP_USERNAME');
        $password = env('IMAP_PASSWORD');

        if (!$host || !$username || !$password) {
            $this->error('Missing email configuration in .env (IMAP_HOST, IMAP_USERNAME, IMAP_PASSWORD).');
            return;
        }

        // Connect manually using Webklex\PHPIMAP\ClientManager to handle Config properly
        $cm = new \Webklex\PHPIMAP\ClientManager();
        
        $this->info("Connecting to $host as $username...");
        
        $client = $cm->make([
            'host'          => $host,
            'port'          => $port,
            'encryption'    => $encryption,
            'validate_cert' => false, 
            'username'      => $username,
            'password'      => $password,
            'protocol'      => 'imap',
            'timeout'       => 15,
            'ssl_options'   => [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ],
        ]);

        try {
            $client->connect();
            $folder = $client->getFolder('INBOX');
            
            // Get all unread messages
            $messages = $folder->query()->unseen()->get();
            $this->info('Found ' . $messages->count() . ' unread messages.');

            foreach ($messages as $message) {
                $subject = $message->getSubject();
                
                // Match [Ticket #ID]
                if (preg_match('/\[Ticket #(\d+)\]/', $subject, $matches)) {
                    $ticketId = $matches[1];
                    $this->info("Processing reply for Ticket #{$ticketId}");

                    $contactQuery = \App\Models\ContactQuery::find($ticketId);

                    if ($contactQuery) {
                        // Get the text body (prefer text/plain)
                        $body = $message->getTextBody() ?: $message->getHTMLBody();
                        
                        // Create reply
                        $contactQuery->replies()->create([
                            'user_id' => null, // Client
                            'message' => trim($body),
                        ]);

                        // Mark as read
                        $message->setFlag(['Seen']);
                        $this->info("Saved reply for Ticket #{$ticketId}");
                        
                        // Optional: Re-open ticket if closed?
                        if ($contactQuery->status === \App\Models\ContactQuery::STATUS_COMPLETE) {
                            $contactQuery->update(['status' => \App\Models\ContactQuery::STATUS_IN_PROGRESS]);
                        }
                    } else {
                        $this->warn("Ticket #{$ticketId} not found.");
                    }
                }
            }

        } catch (\Exception $e) {
            $this->error('Failed to fetch emails: ' . $e->getMessage());
        }
    }
}
