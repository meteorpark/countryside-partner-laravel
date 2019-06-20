<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});



Route::group(['middleware' => 'jwt.auth.custom'], function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::get('auth', 'LoginController@auth'); // 인증 확인

        /*
        --------------------------------------------------------------------------
        | 멘토관련 API
        --------------------------------------------------------------------------
        */
        Route::post('mentors/{mentor_srl}/diaries', 'MentorDiaryController@store'); //  멘토 - 영농일지 등록
        Route::put('mentors/{mentor_srl}/diaries/{diary_srl}', 'MentorDiaryController@update'); //  멘토 - 영농일지 수정
        Route::delete('mentors/{mentor_srl}/diaries/{diary_srl}', 'MentorDiaryController@destroy'); //  멘토 - 영농일지 삭제
        /*
        --------------------------------------------------------------------------
        | 멘티관련 API
        --------------------------------------------------------------------------
        */
        Route::post('mentees/{mentee_srl}/diaries', 'MenteeDiaryController@store'); // 영농일지 등록
        Route::put('mentees/{mentee_srl}/diaries/{diary_srl}', 'MenteeDiaryController@update'); // 영농일지 수정
        Route::delete('mentees/{mentee_srl}/diaries/{diary_srl}', 'MenteeDiaryController@destroy'); // 영농일지 삭제
        /*
        --------------------------------------------------------------------------
        | 멘토링(채팅) API
        --------------------------------------------------------------------------
        */
        Route::get('chat', 'ChatController@chatLists'); // 채팅목록 가져오기
        Route::post('chat/message', 'ChatController@store'); // 메세지 전송
        Route::get('chat/message/{chat_lists_id}', 'ChatController@messagelists'); // 대화 리스트
        /*
        --------------------------------------------------------------------------
        | ... API
        --------------------------------------------------------------------------
        */
        Route::get('users', 'UserController@userInfo'); // 회원정보 가져오기
        Route::put('users', 'UserController@edit'); // 회원정보 수정하기
    });
});



/*
 --------------------------------------------------------------------------
 | OPEN API CALL
 --------------------------------------------------------------------------
 */

Route::group(['prefix' => 'openapi'], function () {
    Route::get('machines', 'OpenApiController@machines'); // 전국 농기계 현황
    Route::get('dictionary', 'OpenApiController@dictionary'); // 우리말 농업용어
    Route::get('special-crops', 'OpenApiController@specialCrops'); // 특용 작물 생산 통계
    Route::get('empty-houses', 'OpenApiController@emptyHouses'); // 농촌 빈집 정보


// 서비스 정지 됨.
//    Route::get('chat/intro', 'OpenApiChatController@intro'); // 귀농귀촌 지능형 상담 - 인트로
//    Route::get('chat/room', 'OpenApiChatController@createRoom'); // 귀농귀촌 지능형 상담 - 채팅방 생성
//    Route::get('chat/msg', 'OpenApiChatController@sendMessage'); // 귀농귀촌 지능형 상담 - 사용자 질의에 대한 상담 답변
});



Route::group(['prefix' => 'v1'], function () {
    Route::get('main', array(
        'as' => 'main',
        'uses' => 'MainController@index'
    ));

    Route::get('mentees', 'MenteeController@index'); // 멘티 전체 조회
    Route::get('mentees/{mentee_srl}', 'MenteeController@view'); // 멘티 프로필 조회
    Route::get('mentees/{mentee_srl}/diaries', 'MenteeDiaryController@menteeDiaries'); // {NAME}멘티의 영농일지
    Route::get('mentees/{mentee_srl}/diaries/{diary_id}', 'MenteeDiaryController@show');//  멘티 - 선택된 영농일지 조회

    Route::get('mentors', 'MentorController@index'); // 멘토 전체 조회
    Route::get('mentors/{mentor_srl}', 'MentorController@view'); // 멘토 프로필 조회
    Route::get('diaries-mentors/{mentor_srl}/articles', 'MentorDiaryController@mentorDiaries'); // {NAME}멘토의 영농일지
    Route::get('diaries-mentors/articles/{diary_id}', 'MentorDiaryController@show');//  멘토 - 선택된 영농일지 조회



    Route::get('diaries-mentors/articles', array( //  멘토 - 영농일지 전체 조회
        'as' => 'diaries-mentors.articles.index',
        'uses' => 'MentorDiaryController@index'
    ));
    Route::post('login', 'LoginController@login'); // 로그인
    Route::post('join/mentor', array( // 멘토 - 회원가입
        'as' => 'join.store',
        'uses' => 'MentorController@store'
    ));
    Route::post('join/mentee', array( // 멘토 - 회원가입
        'as' => 'join.store',
        'uses' => 'MenteeController@store'
    ));
});






