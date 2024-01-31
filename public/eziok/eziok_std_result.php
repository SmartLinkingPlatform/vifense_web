<?php
    // 각 버전 별 맞는 eziokManager-php를 사용
    $eziok_path = __DIR__."/Eziok_Key_Manager_phpseclib_v3.0_v1.0.2.php";

    if(!file_exists($eziok_path)) {
        die('1000|Eziok_Key_Manager파일이 존재하지 않습니다.');
    } else {
        require_once $eziok_path;
    }
?>

<?php
    header("Content-Type:text/html;charset=utf-8");

    // 간편인증-표준창 인증결과 요청 URL
    $target_url = "https://scert.ez-iok.com/agent/auth-verify";  // 개발
   // $target_url = "https://cert.ez-iok.com/agent/auth-verify";   // 운영

    // 간편인증 서비스 API  설정
    $eziok = new Eziok_Key_Manager();
    /* 키파일은 반드시 서버의 안전한 로컬경로에 별도 저장. 웹URL 경로에 파일이 있을경우 키파일이 외부에 노출될 수 있음 주의 */
    $key_path =  __DIR__."/mok_dev_keyInfo.dat"; // 개발
    //$key_path =  __DIR__."/mok_keyInfo.dat"; // 운영
    $password = "Dgtmoby123!@#";
    $eziok->key_init($key_path, $password);
    generate($eziok, $target_url);
?>

<?php
    function keytoken($target_url) {
        // 인증 결과 Key Token
        $key_token = file('php://input'); // retType : "callback"
        $key_token = json_encode(array('keyToken' => $key_token[0]), JSON_UNESCAPED_SLASHES); // retType : "callback"
        //$key_token = json_encode(array('keyToken' => $_POST["hubToken"]), JSON_UNESCAPED_SLASHES); // retType : "redirect"

        if ($key_token === null) {
            echo '-9|간편인증 keytoken 인증결과 응답이 없습니다.';
            return '-9';
        }

        /*1. 간편인증-표준창 HUBToken 요청*/
        $hub_token = sendPost($key_token, $target_url);
        $hub_token = json_decode($hub_token)->hubToken;

        return $hub_token;
    }

    function hubtoken() {
        // $key_token = file('php://input'); // retType : "callback"
        // $hub_token = $key_token[0]; // retType : "callback"
        $hub_token = $_POST["hubToken"]; // retType : "redirect"

        return $hub_token;
    }

    function generate($eziok, $target_url) {
        // local시간 설정이 다르게 될  수 있음으로 기본 시간 설정을 서울로 해놓는다.
        date_default_timezone_set('Asia/Seoul');

        $hub_token = keytoken($target_url);// retTransferType 방식이 keytoken일 경우 사용
        // $hub_token = hubtoken();// retTransferType 방식이 hubtoken일 경우 사용

        /*1. 간편인증-표준창 HUBToken 요청*/
        if ($hub_token == '-9') {
            echo '-9|간편인증 keytoken 인증결과 응답이 없습니다.';
            return '';
        } else if ($hub_token === null) {
            echo '-1|간편인증 hubtoken 인증결과 응답이 없습니다';
            return '';
        }

        try {
            /*2. 간편인증-표준창 HUBToken 처리 결과 복호화*/
            $result_json = $eziok->get_result($hub_token);
        } catch (Exception $e) {
            echo '-2|간편인증 결과 복호화 오류';
            return '';
        }

        try {
            /*3. 간편인증-표준창 결과 설정*/
            $result = json_decode($result_json, true);
            $client_tx_id = $result['clientTxId'];
            $service_type = $result['serviceType'];
            if (isset($result['encCi'], $result)) {
                $enc_ci = $result['encCi'];
            } else {
                $enc_ci = null;
            }
            $enc_user_name = $result['encUsername'];
            $enc_user_phone = $result['encUserphone'];
            $enc_user_birthday = $result['encUserbirthday'];

            $provider_id = $result['providerId'];
            $tx_id = $result['txId'];
            $issue_date = $result['issueDate'];
            $issuer = $result['issuer'];
            if (isset($result['signedData'], $result)) {
                $signed_data = $result['signedData'];
            } else {
                $signed_data = null;
            }
            $plain_data = null;

            /*4. 세션 내 요청 clientTxId 와 수신한 clientTxId 가 동일한지 비교 권고*/
            session_start();
            $session_client_tx_id = $_SESSION['session_client_tx_id'];
            if ($session_client_tx_id !== $client_tx_id){
                echo '-4|세션값에 저장된 거래ID 비교 실패';
                return '';
            }

            /*5. 입력 시간 검증 (토큰 생성 후 10분 이내 검증 권고)*/
            $date_time = date("Y-m-d H:i:s");

            $old = strtotime($issue_date);
            $old = date("Y-m-d H:i:s", $old);

            $time_limit = strtotime($old."+10 minutes");
            $time_limit = date("Y-m-d H:i:s", $time_limit);

            if ($time_limit < $date_time) {
                echo "-5|토큰 생성 10분 경과";
                return '';
            }

            /*6. 인증사업자별 개인정보 결과 복호화*/
            $user_name = $eziok->aes_decode($provider_id, $enc_user_name);
            $user_phone = $eziok->aes_decode($provider_id, $enc_user_phone);
            $user_birthday = $eziok->aes_decode($provider_id, $enc_user_birthday);
            if ($enc_ci != null) {
                $ci = $eziok->aes_decode($provider_id, $enc_ci);
            }

            if ($enc_vid != null) {
                $vid = $eziok->aes_decode($provider_id, $enc_vid);
            }

            /*7. 전자서명 확인*/
            // - 간편서병 요청시 처리 (serviceType : "sign")
            // - 수신한 전자서명의 원문 획득, 전자서명 검증, 인증서 획득, 전자서명 검증이 필요할 경우 별도의 보안툴킷 처리 필요
            // if (jsonObject.getString("serviceType").equals("sign")) {
            // plainData = verifySignedData(signedData);
            //}

            /*8. 이용기관 서비스 기능 처리*/
            // - 이용기관에서 수신한 개인정보 검증 확인
            // - 이용기관에서 수신한 CI 확인

            /*9.응답결과 전달*/
            // - 간편인증-표준창 요청시 "retType": "callback" 일 경우 > callback function 전달
            // - 간편인증-표준창 요청시 "retType": "redirect" 는 결과 페이지로 이동(모바일 WebView 또는 iOS 등 팝업이 안되는 App일경우)
            $values = array('errorCode'=>'2000', 'data'=>$user_name);
            // JSON_UNESCAPED_UNICODE 설정을 안 할 시 한글은 \uC774과 같은 형식으로 출력
            echo '0|'.json_encode($values, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
            echo "-999|서버 오류";
            return '';
        }
    }

    function sendPost($data, $url) {
        $curl = curl_init();                                                              // curl 초기화
        curl_setopt($curl, CURLOPT_URL, $url);                                            // 데이터를 전송 할 URL
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);                                 // 요청결과를 문자열로 반환
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));  // 전송 ContentType을 Json형식으로 설정
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);                                // 원격 서버의 인증서가 유효한지 검사 여부
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                                    // POST DATA
        curl_setopt($curl, CURLOPT_POST, true);                                           // POST 전송 여부
        $response = curl_exec($curl);                                                     // 전송
        curl_close($curl);                                                                // 연결해제

        return $response;
    }
?>
