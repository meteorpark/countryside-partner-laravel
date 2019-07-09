# 시골짝꿍 (백엔드)

두 번째 토이프로젝트로써 <공공데이터 및 빅데이터 활용 창업경진대회> 공모전 참여를 위해 개발된 사이트 입니다.

Web : https://countryside-partner.meteopark.dev

Google Play : https://play.google.com/store/apps/details?id=com.kr.countrysidepartner

## 서비스 개요
본 서비스는 농업사회 발전을 이루기 위해 해당 분야의 전문가와 예비 귀농인을 이어주는 서비스 입니다

## 주요기능
* 각 회원별 블로그 개설
* 멘토와 멘티의 멘토링을 위한 채팅
* 최신 농업소식을 구독할 수 있도록 OpenAPI 적극활용

## 개발스펙
해당 프로젝트는 프론트와 백엔드 그리고 안드로이드(웹뷰)로 나뉘어져 있습니다.

* 프론트
    * ReactJs
    * react-bootstrap

* 백엔트
    * PHP 7.2
    * Laravel 5.8
    * Nginx
    * PHP-FPM
    * MySQL
    * SSL
    * Git

## 구현기술
* Back-End
    * JWT를 활용한 로그인 구현
    * Laravel 주요 기능 활용 ( Envoy, 마이그레이션, 시딩, 옵져버, 파일업로드 등... )
    * OpeAPI 활용 ( Twitter, 농업진흥청, 농촌진흥청 )
    * PHP 표준권고(PSR)를 준수한 코딩
    * Let's Encrypt를 활용한 SSL인증서 발급

* Front-End
    * State Hook, Effect Hook
    * Redux