# 시골짝꿍 ( Laravel )

두 번째 토이프로젝트로써 <공공데이터 및 빅데이터 활용 창업경진대회> 공모전 참여를 위해 개발된 사이트 입니다.

해당 프로젝트는 프론트(리액트)와 백엔드(라라벨) 그리고 안드로이드(웹뷰)로 나뉘어져 있습니다.

Web : https://countryside-partner.meteopark.dev

Google Play : https://play.google.com/store/apps/details?id=com.kr.countrysidepartner

## 서비스 개요
농업사회 발전과 성공적인 귀농을 위해 해당 분야의 전문가(멘토)와 예비 귀농인(멘티)을 이어주는 서비스

## 주요기능
* 회원가입
* 각 회원별 영농일지(블로그) 개설
* 멘토와 멘티의 멘토링을 위한 채팅
* 최신 농업소식을 구독할 수 있도록 외부데이터 활용 ( 농림축산식품부/농촌진흥청 OpenAPI, 트위터, 네이버블로그 Rss )

## 개발
* Ncloud
* ReactJs
* PHP 7.2
* Laravel 5.8
* Nginx 1.15.9
* PHP-FPM
* MySQL 5.8
* Let's Encrypt - Free SSL/TLS Certificates
* Git

## 구현기술
* [Front-End](https://github.com/meteopark/countryside-partner-reactjs)
    * State Hook, Effect Hook, Redux, axios
    * react-bootstrap
* [Back-End](https://github.com/meteopark/countryside-partner-laravel)
    * JWT를 활용한 로그인 구현
    * 공식문서를 최대한 반영하도록 노력 ( Envoy, 마이그레이션, 시딩, 옵져버, 파일업로드 등... )
    * OpeAPI 활용 ( Twitter, 농업진흥청, 농촌진흥청 )
    * PHP 표준권고(PSR)를 준수한 코딩
    * Let's Encrypt를 활용한 SSL인증서 발급
