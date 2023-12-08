<?php
    // 각 버전 별 맞는 mobileOKManager-php를 사용
    $mobileOK_path =  __DIR__."/mobileOK_manager_phpseclib_v3.0_v1.0.1.php";

    if(!file_exists($mobileOK_path)) {
         die('1000|mobileOK_Key_Manager파일이 존재하지 않습니다.');
    } else {
        require_once $mobileOK_path;
    }
?>

<?php
    header("Content-Type:text/html;charset=utf-8");

    /* 1. 본인확인 인증결과 MOKToken API 요청 URL */
    $MOK_RESULT_REQUEST_URL = "https://scert.mobile-ok.com/gui/service/v1/result/request";  // 개발
    // $MOK_RESULT_REQUEST_URL = "https://cert.mobile-ok.com/gui/service/v1/result/request";  //운영

    // (/* 7.2 : 페이지 이동 : redirect 방식, 이용기관 지정 페이지로 이동 */) 이용시 이동 URL
    //$MOK_RESULT_REDIRECT_URL =  __DIR__."/result_page.php";
    $MOK_RESULT_REDIRECT_URL =  "https://dgt.vifense.com/admin.find-password-view";

    /* 2. 본인확인 서비스 API 설정 */
    $mobileOK = new mobileOK_Key_Manager();
    /* 키파일은 반드시 서버의 안전한 로컬경로에 별도 저장. 웹URL 경로에 파일이 있을경우 키파일이 외부에 노출될 수 있음 주의 */
    $key_path =  __DIR__."/mok_dev_keyInfo.dat"; // 개발
    //$key_path =  __DIR__."/mok_keyInfo.dat"; // 운영
    $password = "Dgtmoby123!@#";
    $mobileOK->key_init($key_path, $password);
?>

<?php
    /* 본인확인 표준창 결과 요청 예제 함수 */
    function mobileOK_std_result($mobileOK, $MOK_RESULT_REQUEST_URL) {
        // local시간 설정이 다르게 될  수 있음으로 기본 시간 설정을 서울로 해놓는다.
        date_default_timezone_set('Asia/Seoul');

        /* 3. 본인확인 인증 결과 암호문 수신 */
        $request_array = $_POST['data'];
        $request_array = urldecode($request_array);
        $request_array = json_decode($request_array);

        /* 4. 본인확인 결과 타입별 결과 처리 */
        if (isset($request_array->encryptMOKKeyToken)) {
            /* 4.1 본인확인 결과 타입 : MOKToken */
            $encrypt_MOK_token = $request_array->encryptMOKKeyToken;
            $result_request_array = array(
                "encryptMOKKeyToken" => $encrypt_MOK_token
            );
            $result_request_json = json_encode($result_request_array, JSON_UNESCAPED_SLASHES);

            $result_response_json = sendPost($result_request_json, $MOK_RESULT_REQUEST_URL);
            $result_response_array = json_decode($result_response_json);

            $encryptMOKResult = $result_response_array->encryptMOKResult;
        } else if (isset($request_array->encryptMOKResult)) {
            /* 4.2 본인확인 결과 타입 : MOKResult */
            $encryptMOKResult = $request_array->encryptMOKResult;
        } else {
            die("-1|본인확인 MOKToken 인증결과 응답이 없습니다.");
        }

        /* 5. 본인확인 결과 JSON 정보 처리 */
        try {
            $decrypt_result_json = $mobileOK->get_result($encryptMOKResult);
            $decrypt_result_array = json_decode($decrypt_result_json);
        } catch (Exception $e) {
            return '-2|본인확인 결과 복호화 오류';
        }

        /* 5-1 본인확인 결과정보 복호화 */

        /* 사용자 이름 */
        $user_name = isset($decrypt_result_array->userName) ? $decrypt_result_array->userName : null;
        /* 이용기관 ID */
        $site_id = isset($decrypt_result_array->siteID) ? $decrypt_result_array->siteID : null;
        /* 이용기관 거래 ID */
        $client_tx_id = isset($decrypt_result_array->clientTxId) ? $decrypt_result_array->clientTxId : null;
        /* 본인확인 거래 ID */
        $tx_id = isset($decrypt_result_array->txId) ? $decrypt_result_array->txId : null;
        /* 서비스제공자(인증사업자) ID */
        $provider_id = isset($decrypt_result_array->providerId) ? $decrypt_result_array->providerId : null;
        /* 이용 서비스 유형 */
        $service_type = isset($decrypt_result_array->serviceType) ? $decrypt_result_array->serviceType : null;
        /* 시용자 CI */
        $ci = isset($decrypt_result_array->ci) ? $decrypt_result_array->ci : null;
        /* 사용자 DI */
        $di = isset($decrypt_result_array->di) ? $decrypt_result_array->di : null;
        /* 사용자 전화번호 */
        $user_phone = isset($decrypt_result_array->userPhone) ? $decrypt_result_array->userPhone : null;
        /* 사용자 생년월일 */
        $user_birthday = isset($decrypt_result_array->userBirthday) ? $decrypt_result_array->userBirthday : null;
        /* 사용자 성별 (1: 남자, 2: 여자) */
        $user_gender = isset($decrypt_result_array->userGender) ? $decrypt_result_array->userGender : null;
        /* 사용자 국적 (0: 내국인, 1: 외국인) */
        $user_nation = isset($decrypt_result_array->userNation) ? $decrypt_result_array->userNation : null;
        /* 본인확인 인증 종류 */
        $req_auth_type = $decrypt_result_array->reqAuthType;
        /* 본인확인 요청 시간 */
        $req_date = $decrypt_result_array->reqDate;
        /* 본인확인 인증 서버 */
        $issuer = $decrypt_result_array->issuer;
        /* 본인확인 인증 시간 */
        $issue_date = $decrypt_result_array->issueDate;

        /* 6. 세션 내 요청 clientTxId 와 수신한 clientTxId 가 동일한지 비교 권고*/
        session_start();
        $session_client_tx_id = $_SESSION['sessionClientTxId'];

        if ($session_client_tx_id !== $client_tx_id){
            echo '-4|세션값에 저장된 거래ID 비교 실패';
            return '';
        }

        /* 7. 이용기관 서비스 기능 처리 */
        // - 이용기관에서 수신한 개인정보 검증 확인 처리
        // - 이용기관에서 수신한 CI 확인 처리

        /* 8. 본인확인 결과 응답 */
        $result_array = array(
            "resultCode" => "2000"
            , "resultMsg" => "성공"
            , "userName" => $user_name
            , "providerId" => $provider_id
            , "serviceType" => $service_type
            , "userPhone" => $user_phone
            , "userBirthday" => $user_birthday
            , "userGender" => $user_gender
            , "userNation" => $user_nation
            , "reqAuthType" => $req_auth_type
            , "reqDate" => $req_date
        );

        $result_json = json_encode($result_array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return $result_json;
    }

    /* 본인확인 서버 통신 예제 함수 */
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
<?php
    /* 7. 본인확인 결과 응답 방식 */
    /* 7.1 : 팝업창 : callback 함수 사용 */
    echo mobileOK_std_result($mobileOK, $MOK_RESULT_REQUEST_URL);
?>
<?php
    // redirect 모드 이용시 "7.1 : 팝업창 : callback 함수 사용"  주석 처리 후 "7.2 : 페이지 이동" form 태그 주석제거 후 활성화

    /* 7.2 : 페이지 이동 : redirect 방식, 이용기관 지정 페이지로 이동 */
    /*
    <form method="post" action="
    <?php
        echo $MOK_RESULT_REDIRECT_URL;
    ?>
    ">
        <textarea style="width:500px; height: 500px" name="data">
           <?php
               echo mobileOK_std_result($mobileOK, $MOK_RESULT_REQUEST_URL);
           ?>
       </textarea>
    </form>
    */
?>
