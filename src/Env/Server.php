<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 14/07/18
 * Time: 11:20
 */

namespace AW\Env;


class Server extends AbstractEnv
{
    public function __construct($varEnv)
    {
        $this->bootstrap($varEnv??$_SERVER);
    }

}