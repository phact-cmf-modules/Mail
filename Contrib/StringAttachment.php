<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @date 12/03/2019 08:36
 */

namespace Modules\Mail\Contrib;


class StringAttachment
{
    private $content;
    /**
     * @var string
     */
    private $name;

    /**
     * StringAttachment constructor.
     * @param $content
     * @param string $name
     */
    public function __construct($content, string $name)
    {

        $this->content = $content;
        $this->name = $name;
    }

    /**
     * @param mixed $content
     * @return StringAttachment
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $name
     * @return StringAttachment
     */
    public function setName(string $name): StringAttachment
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}