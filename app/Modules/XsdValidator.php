<?php


namespace App\Modules;


class XsdValidator
{

    /**
     * @var string
     */
    public $feedSchema = null;
    /**
     * @var int
     */
    public $feedErrors = 0;
    /**
     * Formatted libxml Error details
     *
     * @var array
     */
    public $errorDetails;

    public $errorMessages;
    /**
     * Validation Class constructor Instantiating DOMDocument
     *
     * @param \DOMDocument $handler [description]
     */
    public function __construct()
    {
        $this->handler = new \DOMDocument('1.0', 'utf-8');
    }
    /**
     * @param \libXMLError object $error
     *
     * @return string
     */
    private function libxmlDisplayError($error)
    {
        $errorString = "Error $error->code in $error->file (Line:{$error->line}):";
        $errorString .= trim($error->message);
        return $errorString;
    }
    /**
     * @return array
     */
    private function libxmlGetErrors()
    {
        $errors = libxml_get_errors();
        $result    = [];
        foreach ($errors as $error) {
            $result[] = [
                'code' => $error->code,
                'file' => $error->file,
                'line' => $error->line,
                'message' => $error->message
            ];
//            $this->libxmlDisplayError($error);
        }
        libxml_clear_errors();
        return $result;
    }
    /**
     * Validate Incoming Feeds against Listing Schema
     *
     * @param resource $feeds
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function validateFeeds($feeds)
    {
        if (!class_exists('DOMDocument')) {
            throw new \DOMException("'DOMDocument' class not found!");
            return false;
        }
        if (!file_exists($this->feedSchema)) {
            throw new \Exception('Schema is Missing, Please add schema to feedSchema property');
            return false;
        }
        libxml_use_internal_errors(true);
        if (!($fp = fopen($feeds, "r"))) {
            die("could not open XML input");
        }

        $contents = fread($fp, filesize($feeds));
        fclose($fp);

        $this->handler->loadXML($contents, LIBXML_NOBLANKS);
        if (!$this->handler->schemaValidate($this->feedSchema)) {
            $this->errorDetails = $this->libxmlGetErrors();
            $this->feedErrors   = 1;
        } else {
            //The file is valid
            return true;
        }
    }

    /**
     * Validate Incoming Feeds against Listing Schema
     *
     * @param resource $feeds
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function validateFeedsStr($contents)
    {
        if (!class_exists('DOMDocument')) {
            throw new \DOMException("'DOMDocument' class not found!");
            return false;
        }
        if (!file_exists($this->feedSchema)) {
            throw new \Exception('Schema is Missing, Please add schema to feedSchema property');
            return false;
        }
        libxml_use_internal_errors(true);

        $this->handler->loadXML($contents, LIBXML_NOBLANKS);
        if (!$this->handler->schemaValidate($this->feedSchema)) {
            $this->errorDetails = $this->libxmlGetErrors();
            $this->feedErrors   = 1;
        } else {
            //The file is valid
            return true;
        }
    }

    public function validateFeedsFile($feeds)
    {
        if (!class_exists('DOMDocument')) {
            throw new \DOMException("'DOMDocument' class not found!");
            return false;
        }
        if (!file_exists($this->feedSchema)) {
            throw new \Exception('Schema is Missing, Please add schema to feedSchema property');
            return false;
        }
        libxml_use_internal_errors(true);
        if (!($fp = fopen($feeds, "r"))) {
            die("could not open XML input");
        }

        $contents = fread($fp, filesize($feeds));
        fclose($fp);

        $this->handler->loadXML($contents, LIBXML_NOBLANKS);
        if (!$this->handler->schemaValidate($this->feedSchema)) {
            $this->errorDetails = $this->libxmlDisplayErrors();
            $this->feedErrors   = 1;
        } else {
            //The file is valid
            return true;
        }
    }

    /**
     * Display Error if Resource is not validated
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errorDetails;
    }

    public function getErrorsMessage()
    {
        foreach ($this->errorDetails as $error) {
            $this->errorMessages[] = $error['message'];
        }
        return $this->errorMessages;
    }
}
