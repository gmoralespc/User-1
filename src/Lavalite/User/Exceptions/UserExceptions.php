<?php namespace Lavalite\User\Exceptions;
/**
 * Part of the Lavalite package.
 *
 *
 * @package    Lavalite
 * @version    2.0.0
 */

class LoginRequiredException extends \UnexpectedValueException {}
class PasswordRequiredException extends \UnexpectedValueException {}
class UserAlreadyActivatedException extends \RuntimeException {}
class UserNotFoundException extends \OutOfBoundsException {}
class UserNotActivatedException extends \RuntimeException {}
class UserExistsException extends \UnexpectedValueException {}
class WrongPasswordException extends UserNotFoundException {}
