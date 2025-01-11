<?php
final class NotificationModel {

    /**
     * Get all notifications for a specific user, if no user is provided, the current user will be used.
     * @param int|null $id_user
     * @return array
     */
    public function getNotifications($id_user = null) {
        return Database::getInstance()->executeResults(
            "SELECT n.id_notification,
                n.id_user,
                n.message, 
                n.link,
                n.is_read, 
                n.created_at
                FROM notifications n
                WHERE id_user = ? ORDER BY n.created_at DESC",
            'i',
            $id_user ?? Session::getUser()
        );
    }

    /**
     * Mark a notification as read
     *
     * @param int $id_notification
     * @return bool
     */
    public function readNotification($id_notification) {
        return Database::getInstance()->executeQueryAffectRows(
            "UPDATE notifications SET is_read = 1 WHERE id_notification = ?",
            'i',
            $id_notification
        );
    }

    /**
     * Create a new notification for a specific user
     * always check if the user has the notifications enabled
     *
     * @param int $id_user
     * @param string $message
     * @return bool true if the notification is created, false otherwise.
     */
    public function createNotification($id_user, $message, $link = null) {
        $result = Database::getInstance()->executeResults("SELECT notifications FROM users WHERE id_user = ?", 'i', $id_user);
        if (empty($result) || !isset($result[0]['notifications']) || !$result[0]['notifications']) {
            return false;
        }

        return Database::getInstance()->executeQueryAffectRows(
            "INSERT INTO notifications (`id_user`, `message`, `link`) VALUES (?, ?, ?)",
            'iss',
            $id_user,
            $message,
            $link ?? ''
        );
    }

    /**
     * Delete a notification for a specific user, if no user is provided, the current user will be used.
     *
     * @param int|null $id_user
     * @return bool
     */
    public function deleteNotification($id_notification, $id_user = null) {
        return Database::getInstance()->executeQueryAffectRows(
            "DELETE FROM notifications WHERE id_notification = ? AND id_user = ?",
            'ii',
            $id_notification,
            $id_user ?? Session::getUser()
        );
    }

    /**
     * Broadcast a notification to specific users
     *
     * @param array $users is an array of users with the id_user key
     * @param string $message
     * @param string $link
     * 
     * @return void
     */
    public function broadcastFor($users, $message, $link = null) {
        foreach ($users as $user) {
            $this->createNotification($user['id_user'], $message, $link);
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
