<?php namespace SimpleSoftwareIO\QrCode\DataTypes;
use BaconQrCode\Exception\InvalidArgumentException;

/**
 * Simple Laravel QrCode Generator
 * A simple wrapper for the popular BaconQrCode made for Laravel.
 *
 * @link http://www.simplesoftware.io
 * @author SimpleSoftware support@simplesoftware.io
 *
 */

class Email implements DataTypeInterface {

    /**
     * The email address
     *
     * @var string
     */
    protected $email;

    /**
     * The subject of the email
     *
     * @var string
     */
    protected $subject;

    /**
     * The body of an email.
     *
     * @var string
     */
    protected $body;

    /**
     * Generates the DataType Object and sets all of its properties.
     *
     * @param $arguments
     * @return void
     */
    public function create(Array $arguments)
    {
        $this->setProperties($arguments);
    }

    /**
     * Returns the correct QrCode format.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->buildEmailString();
    }

    /*
     * Builds the email string.
     *
     * @return string
     */
    private function buildEmailString()
    {
        $email = 'mailto:' . $this->email;

        if (isset($this->subject) || isset($this->body))
        {
            $email .= '?';
            $data = [
                'subject' => $this->subject,
                'body' => $this->body
            ];
            $email .= http_build_query($data);
        }

        return $email;
    }

    /**
     * Sets the objects properties
     *
     * @param $arguments
     */
    private function setProperties(Array $arguments)
    {
        //If passed as a single variable and not in an array
        if (isset($arguments[0])) $this->setEmail($arguments[0]);
        if (isset($arguments[1])) $this->subject = $arguments[1];
        if (isset($arguments[2])) $this->body = $arguments[2];
    }

    /**
     * Sets the email property
     *
     * @param $email
     */
    private function setEmail($email)
    {
        if ( $this->isValidEmail($email)) $this->email = $email;
    }

    /**
     * Ensures an email is valid
     *
     * @param string $email
     * @return bool
     */
    private function isValidEmail($email)
    {
        if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email provided');
        }

        return true;
    }

}