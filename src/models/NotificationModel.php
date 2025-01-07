<?php
final class NotificationModel {

    /**
     * Get all notifications for a specific user, if no user is provided, the current user will be used.
     * @param int|null $id_user
     * @return array
     */
    public function getNotifications($id_user = null) {
        $notification = Database::getInstance()->executeResults(
            "SELECT n.id_notification,
                n.id_user,
                n.message, 
                n.link,
                n.is_read, 
                n.created_at
                FROM notifications n
                WHERE id_user = ? ORDER BY date DESC",
            '',
            $id_user ?? Session::getUser()
        );
        if ($notification) {
            foreach ($notification as $key => $value) {
                $this->readNotification($value['id_notification']);
            }
        }
        return $notification;
    }

    /**
     * Mark a notification as read
     *
     * @param int $id_notification
     * @return bool
     */
    private function readNotification($id_notification) {
        return Database::getInstance()->executeQueryAffectRows(
            "UPDATE notifications SET is_read = 1 WHERE id_notification = ?",
            'i',
            $id_notification
        );
    }
    
    /**
     * Create a new notification for a specific user
     * always check if the user has the newsletter enabled
     *
     * @param int $id_user
     * @param string $message
     * @return bool true if the notification is created, false otherwise.
     */
    private function createNotification($id_user, $message, $link = null) {
        // Check if the result is not empty and the 'newsletter' key exists
        $result = Database::getInstance()->executeResults("SELECT newsletter FROM users WHERE id_user = ?", 'i', $id_user);
        if (empty($result) || !isset($result[0]['newsletter']) || !$result[0]['newsletter']) {
            return false;
        }

        return Database::getInstance()->executeQueryAffectRows(
            "INSERT INTO notifications (`id_user`, `message`, `link`) VALUES (?, ?, ?)",
            'ss',
            $id_user,
            $message,
            $link ?? ''
        );
    }

    /**
     * Delete all read notifications for a specific user, if no user is provided, the current user will be used.
     *
     * @param int|null $id_user
     * @return bool
     */
    public function deleteNotifications($id_user = null) {
        return Database::getInstance()->executeQueryAffectRows(
            "DELETE FROM notifications WHERE `is_read` = 1 AND `id_user` = ?",
            'i',
            $id_user ?? Session::getUser()
        );
    }

    /**
     * Broadcast a notification to specific users
     *
     * @param array $users NEED `newletter` and `id_user` keys
     * @param string $message
     * @param string $link
     * 
     * @return void
     */
    public function broadcastFor($users, $message, $link = null) {
        foreach ($users as $key => $value) {
            $this->createNotification($value, $message, $link);
        }
    }

    /**
     * Broadcast a notification to all users
     *
     * @param string $message
     * @return void
     */
    public function broadcast($message, $link = null) {
        $this->broadcastFor(Database::getInstance()->executeResults("SELECT id_user FROM users"), $message, $link);
    }

}
