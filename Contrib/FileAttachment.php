<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @date 12/03/2019 08:27
 */

namespace Modules\Mail\Contrib;


class FileAttachment
{
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $encoding;
    /**
     * @var string
     */
    private $type;

    public function __construct(string $path, string $name = '', string $encoding = 'base64', $type = '')
    {
        $this->path = $path;
        $this->name = $name;
        $this->encoding = $encoding;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return FileAttachment
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getEncoding(): string
    {
        return $this->encoding;
    }

    /**
     * @param string $encoding
     * @return FileAttachment
     */
    public function setEncoding(string $encoding): self
    {
        $this->encoding = $encoding;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return FileAttachment
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return FileAttachment
     */
    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }
}