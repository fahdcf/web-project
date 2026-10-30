# Runtime data and repository hygiene

Laravel logs and the local `dump.sql` artifact are not distributed as source.
Runtime logs were removed from all current branches, including the two public
non-default branches that contained populated logs. Existing migrations and
frontend assets remain unchanged. Keep shared editor settings if useful.

Run migrations to initialize a local database. Laravel creates its logs directory
at runtime; retain the existing `storage/logs/.gitignore` directory placeholder.
Do not commit operational logs, local environment files or populated account
dumps. Log events should avoid unnecessary personal data and credentials.

Older commits still contain removed logs; current-branch cleanup does not erase
those copies. Review whether historical personal data warrants a separately
coordinated history cleanup and any appropriate account protection.
