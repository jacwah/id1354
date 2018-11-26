<?php
namespace TastyRecipes\View;

use \TastyRecipes\Model\ValidationException;
use \TastyRecipes\Model\Comment;

class StatusMessage {
    public const DATABASE_ERROR = 'Operation failed. Please try again later.';

    public static function commentValidation(ValidationException $exception) {
        switch ($exception->getType()) {
        case Comment::CONTENT_TOO_SHORT:
            $status = 'Comment must be at least ' . Comment::MIN_LENGTH . ' characters';
            break;
        case Comment::CONTENT_TOO_LONG:
            $status = 'Comment can be at most ' . Comment::MAX_LENGTH . ' characters';
            break;
        }
        return $status;
    }
}
