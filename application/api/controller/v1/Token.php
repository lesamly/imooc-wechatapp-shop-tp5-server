<?php

namespace app\api\controller\v1;

use think\Controller;
use app\api\validate\TokenGet;
use app\api\validate\AppTokenGet;
use app\api\service\UserToken;
use app\api\service\AppToken;
use app\api\service\Token as TokenService;

use app\lib\exception\ParameterException;

class Token extends Controller
{
    public function getToken($code = ""){
      (new TokenGet())->goCheck();
      $ut = new UserToken($code);
      $token = $ut->get();
      return [
        "token" => $token
      ];
    }

    /**
     * 第三方应用获取令牌
     * @url /app_token?
     * @POST ac=:ac se=:secret
     */
    public function getAppToken($ac='', $se='')
    {
        (new AppTokenGet())->goCheck();
        $app = new AppToken();
        $token = $app->get($ac, $se);
        return [
            'token' => $token
        ];
    }

    public function verifyToken($token=""){
      if (!$token) {
        throw new ParameterException("token不允许为空");
      }
      $valid = TokenService::verifyToken($token);
      return [
        "isValid" => $valid
      ];
    }
}
