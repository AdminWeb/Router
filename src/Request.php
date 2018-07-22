<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 14/07/18
 * Time: 11:01
 */

namespace AW;


use AW\Env\Get;
use AW\Env\Post;
use AW\Env\Server;

class Request
{
    private $attrs = [], $uri = '', $server = [], $post = [], $get = [], $files = [], $session = [];
    public function __construct(array $server = [], array $post = [], array $get = [], array $files = [], array $session = [], $uri = '')
    {
        $this->setPost(new Post($post));
        $this->setGet(new Get($get));
        $this->setServer(new Server($server));
    }


    public static function createFromGlobals(array $server = [], array $post = [], array $get = [], array $files = [], array $session = [], $uri = ''){
        return new static($server, $post, $get, $files, $session, $uri);
    }

    public function __get($name)
    {
        return $this->attrs[":{$name}"];
    }

    public function addParams(array $attrs)
    {
        $this->attrs = $attrs;
        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     * @return Request
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @return array
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param array $server
     * @return Request
     */
    public function setServer($server)
    {
        $this->server = $server;
        return $this;
    }

    /**
     * @return array
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param array $post
     * @return Request
     */
    public function setPost($post)
    {
        $this->post = $post;
        return $this;
    }

    /**
     * @return array
     */
    public function getGet()
    {
        return $this->get;
    }

    /**
     * @param array $get
     * @return Request
     */
    public function setGet($get)
    {
        $this->get = $get;
        return $this;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param array $files
     * @return Request
     */
    public function setFiles($files)
    {
        $this->files = $files;
        return $this;
    }

    /**
     * @return array
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param array $session
     * @return Request
     */
    public function setSession($session)
    {
        $this->session = $session;
        return $this;
    }

    /**
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * @param array $cookies
     * @return Request
     */
    public function setCookies($cookies)
    {
        $this->cookies = $cookies;
        return $this;
    }


}