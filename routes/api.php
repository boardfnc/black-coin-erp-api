<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/** 사용자 로그인 */
Route::post('auth/login', [App\Http\Controllers\Auth\JWTAuthController::class, 'authenticate'])->name('AuthLoginPost');

Route::group(['middleware' => ['jwt.verify']], function() {
    // Auth
    Route::delete('auth/logout', [App\Http\Controllers\Auth\JWTAuthController::class, 'logout'])->name('AuthLogoutDelete');
    Route::post('auth/refresh', [App\Http\Controllers\Auth\JWTAuthController::class, 'refresh'])->name('AuthRefreshPost');

    // Statistics - SuperAdmin
    /** 날짜 별 통계 - 슈퍼어드민 */
    Route::get( 'statistics/admin-dates', [App\Http\Controllers\Statistics\AdminDateController::class, 'index'])->name('StatisticsAdminDatesGet');

    // Member - SuperAdmin
    /** 회원관리 - 슈퍼어드민 */
    Route::get( 'member/admin-managers', [App\Http\Controllers\Member\AdminManagerController::class, 'index'])->name('MemberAdminManagersGet');
    Route::get( 'member/admin-manager/{id}', [App\Http\Controllers\Member\AdminManagerController::class, 'show'])->name('MemberAdminManagerGet')->where('id', '[0-9]+');
    Route::get( 'member/admin-manager/dealings/{id}', [App\Http\Controllers\Member\AdminManagerController::class, 'dealings'])->name('MemberAdminManagerDealingsGet')->where('id', '[0-9]+');
    Route::post( 'member/admin-manager', [App\Http\Controllers\Member\AdminManagerController::class, 'store'])->name('MemberAdminManagerPost');
    Route::put( 'member/admin-manager/account-update/{id}', [App\Http\Controllers\Member\AdminManagerController::class, 'accountUpdate'])->name('MemberAdminManagerAccountUpdatePut')->where('id', '[0-9]+');
    Route::put( 'member/admin-manager/account-number-update/{id}', [App\Http\Controllers\Member\AdminManagerController::class, 'accountUpdate'])->name('MemberAdminManagerAccountNumberUpdatePut')->where('id', '[0-9]+');
    Route::put( 'member/admin-manager/fee-update/{id}', [App\Http\Controllers\Member\AdminManagerController::class, 'feeUpdate'])->name('MemberAdminManagerFeeUpdatePut')->where('id', '[0-9]+');
    Route::put( 'member/admin-manager/status-update/{id}', [App\Http\Controllers\Member\AdminManagerController::class, 'statusUpdate'])->name('MemberAdminManagerStatusUpdatePut')->where('id', '[0-9]+');

    Route::get( 'member/admin-members', [App\Http\Controllers\Member\AdminMemberController::class, 'index'])->name('MemberAdminMembersGet');
    Route::get( 'member/admin-member/{id}', [App\Http\Controllers\Member\AdminMemberController::class, 'show'])->name('MemberAdminMemberGet')->where('id', '[0-9]+');
    Route::get( 'member/admin-member/dealings/{id}', [App\Http\Controllers\Member\AdminMemberController::class, 'dealings'])->name('MemberAdminMemberDealingsGet')->where('id', '[0-9]+');
    Route::put( 'member/admin-member/password-update/{id}', [App\Http\Controllers\Member\AdminMemberController::class, 'passwordUpdate'])->name('MemberAdminMemberPasswordUpdatePut')->where('id', '[0-9]+');
    Route::put( 'member/admin-member/status-update/{id}', [App\Http\Controllers\Member\AdminMemberController::class, 'statusUpdate'])->name('MemberAdminMemberStatusUpdatePut')->where('id', '[0-9]+');
    Route::put( 'member/admin-member/account-number-update/{id}', [App\Http\Controllers\Member\AdminMemberController::class, 'accountNumberUpdate'])->name('MemberAdminMemberAccountNumberUpdatePut')->where('id', '[0-9]+');
    Route::put( 'member/admin-member/grade-update/{id}', [App\Http\Controllers\Member\AdminMemberController::class, 'gradeUpdate'])->name('MemberAdminMemberGradeUpdatePut')->where('id', '[0-9]+');
    Route::put( 'member/admin-member/grade-initialization/{id}', [App\Http\Controllers\Member\AdminMemberController::class, 'gradeInitialization'])->name('MemberAdminMemberGradeInitializationPut')->where('id', '[0-9]+');
    Route::post( 'member/admin-member/retrieval', [App\Http\Controllers\Member\AdminMemberController::class, 'retrieval'])->name('MemberAdminMemberRetrievalPost');
    Route::post( 'member/admin-member/payment', [App\Http\Controllers\Member\AdminMemberController::class, 'payment'])->name('MemberAdminMemberPaymentPost');

    Route::get( 'member/admin-member-subscribes', [App\Http\Controllers\Member\AdminMemberSubscribeController::class, 'index'])->name('MemberAdminMemberSubscribesGet');
    Route::post( 'member/admin-member-subscribe/consent', [App\Http\Controllers\Member\AdminMemberSubscribeController::class, 'consent'])->name('MemberAdminMemberSubscribeConsentPost');
    Route::post( 'member/admin-member-subscribe/rejection', [App\Http\Controllers\Member\AdminMemberSubscribeController::class, 'rejection'])->name('MemberAdminMemberSubscribeRejectionPost');

    Route::get( 'member/admin-member-grades', [App\Http\Controllers\Member\AdminMemberGradeController::class, 'index'])->name('MemberAdminMemberGradesGet');
    Route::put( 'member/admin-member-grade/{id}', [App\Http\Controllers\Member\AdminMemberGradeController::class, 'update'])->name('MemberAdminMemberGradePut')->where('id', '[0-9]+');

    Route::get( 'member/admin-retrieval-members', [App\Http\Controllers\Member\AdminRetrievalMemberController::class, 'index'])->name('MemberAdminRetrievalMembersGet');

    // Dealings - SuperAdmin
    /** 거래 내역 - 슈퍼어드민 */
    Route::get( 'dealings/admin-manager-details', [App\Http\Controllers\Dealings\AdminManagerDetailController::class, 'index'])->name('DealingsAdminManagerDetailsGet');
    Route::get( 'dealings/admin-manager-detail/history', [App\Http\Controllers\Dealings\AdminManagerDetailController::class, 'history'])->name('DealingsAdminManagerDetailHistoryGet');

    Route::get( 'dealings/admin-member-details', [App\Http\Controllers\Dealings\AdminMemberDetailController::class, 'index'])->name('DealingsAdminMemberDetailsGet');
    Route::get( 'dealings/admin-member-detail/history', [App\Http\Controllers\Dealings\AdminMemberDetailController::class, 'history'])->name('DealingsAdminMemberDetailHistoryGet');

    // Coin - SuperAdmin
    /** 코인 관리 - 슈퍼어드민 */
    Route::get( 'coin/admin-purchase-managers', [App\Http\Controllers\Coin\AdminPurchaseManagerController::class, 'index'])->name('CoinAdminPurchaseManagersGet');
    Route::get( 'coin/admin-purchase-manager/history', [App\Http\Controllers\Coin\AdminPurchaseManagerController::class, 'history'])->name('CoinAdminPurchaseManagerHistoryGet');
    Route::post( 'coin/admin-purchase-manager', [App\Http\Controllers\Coin\AdminPurchaseManagerController::class, 'store'])->name('CoinAdminPurchaseManagerPost');

    Route::get( 'coin/admin-purchase-members', [App\Http\Controllers\Coin\AdminPurchaseMemberController::class, 'index'])->name('CoinAdminPurchaseMembersGet');
    Route::get( 'coin/admin-purchase-member/history', [App\Http\Controllers\Coin\AdminPurchaseMemberController::class, 'history'])->name('CoinAdminPurchaseMemberHistoryGet');
    Route::post( 'coin/admin-purchase-member', [App\Http\Controllers\Coin\AdminPurchaseMemberController::class, 'store'])->name('CoinAdminPurchaseMemberPost');

    Route::get( 'coin/admin-sale-managers', [App\Http\Controllers\Coin\AdminSaleManagerController::class, 'index'])->name('CoinAdminSaleManagersGet');
    Route::get( 'coin/admin-sale-manager/history', [App\Http\Controllers\Coin\AdminSaleManagerController::class, 'history'])->name('CoinAdminSaleManagerHistoryGet');
    Route::post( 'coin/admin-sale-manager', [App\Http\Controllers\Coin\AdminSaleManagerController::class, 'store'])->name('CoinAdminSaleManagerPost');

    Route::get( 'coin/admin-sale-members', [App\Http\Controllers\Coin\AdminSaleMemberController::class, 'index'])->name('CoinAdminSaleMembersGet');
    Route::get( 'coin/admin-sale-member/history', [App\Http\Controllers\Coin\AdminSaleMemberController::class, 'history'])->name('CoinAdminSaleMemberHistoryGet');
    Route::post( 'coin/admin-sale-member', [App\Http\Controllers\Coin\AdminSaleMemberController::class, 'store'])->name('CoinAdminSaleMemberPost');

    Route::get( 'coin/admin-received-details', [App\Http\Controllers\Coin\AdminReceivedDetailController::class, 'index'])->name('CoinAdminReceivedDetailsGet');

    Route::get( 'coin/admin-sent-details', [App\Http\Controllers\Coin\AdminSentDetailController::class, 'index'])->name('CoinAdminSentDetailsGet');

    Route::get( 'coin/admin-dealings-fee-details', [App\Http\Controllers\Coin\AdminDealingsFeeDetailController::class, 'index'])->name('CoinAdminDealingsFeeDetailsGet');

    // Setup - SuperAdmin
    /** 계좌관리 - 슈퍼어드민 */
    Route::get( 'setup/admin-account', [App\Http\Controllers\Setup\AdminAccountController::class, 'show'])->name('SetupAdminAccountGet');
    Route::post( 'setup/admin-account', [App\Http\Controllers\Setup\AdminAccountController::class, 'store'])->name('SetupAdminAccountPost');

    // Statistics
    /** 날짜 별 통계 */
    Route::get( 'statistics/dates', [App\Http\Controllers\Statistics\DateController::class, 'index'])->name('StatisticsDatesGet');

    // Member
    /** 회원관리 */
    Route::get( 'member/members', [App\Http\Controllers\Member\MemberController::class, 'index'])->name('MemberMembersGet');
    Route::get( 'member/member/{id}', [App\Http\Controllers\Member\MemberController::class, 'show'])->name('MemberMemberGet')->where('id', '[0-9]+');
    Route::get( 'member/member/dealings/{id}', [App\Http\Controllers\Member\MemberController::class, 'dealings'])->name('MemberMemberDealingsGet')->where('id', '[0-9]+');
    Route::put( 'member/member/password-update/{id}', [App\Http\Controllers\Member\MemberController::class, 'passwordUpdate'])->name('MemberMemberPasswordUpdatePut')->where('id', '[0-9]+');
    Route::put( 'member/member/status-update/{id}', [App\Http\Controllers\Member\MemberController::class, 'statusUpdate'])->name('MemberMemberStatusUpdatePut')->where('id', '[0-9]+');
    Route::put( 'member/member/account-number-update/{id}', [App\Http\Controllers\Member\MemberController::class, 'accountNumberUpdate'])->name('MemberMemberAccountNumberUpdatePut')->where('id', '[0-9]+');
    Route::put( 'member/member/grade-update/{id}', [App\Http\Controllers\Member\MemberController::class, 'gradeUpdate'])->name('MemberMemberGradeUpdatePut')->where('id', '[0-9]+');
    Route::post( 'member/member/retrieval', [App\Http\Controllers\Member\MemberController::class, 'retrieval'])->name('MemberMemberRetrievalPost');
    Route::post( 'member/member/payment', [App\Http\Controllers\Member\MemberController::class, 'payment'])->name('MemberMemberPaymentPost');

    Route::get( 'member/member-grade', [App\Http\Controllers\Member\MemberGradeController::class, 'show'])->name('MemberMemberGradeGet');
    Route::put( 'member/member-grade', [App\Http\Controllers\Member\MemberGradeController::class, 'update'])->name('MemberMemberGradePut');

    Route::get( 'member/retrieval-members', [App\Http\Controllers\Member\RetrievalMemberController::class, 'index'])->name('MemberRetrievalMembersGet');

    Route::get( 'member/my-page', [App\Http\Controllers\Member\MyPageController::class, 'show'])->name('MemberMyPageGet');
    Route::get( 'member/my-page/dealings', [App\Http\Controllers\Member\MyPageController::class, 'dealings'])->name('MemberMyPageDealingsGet');
    Route::put( 'member/my-page/password-update', [App\Http\Controllers\Member\MyPageController::class, 'passwordUpdate'])->name('MemberMyPagePasswordUpdatePut');
    Route::put( 'member/my-page/account-update', [App\Http\Controllers\Member\MyPageController::class, 'accountUpdate'])->name('MemberMyPageAccountUpdatePut');
    Route::put( 'member/my-page/account-number-update', [App\Http\Controllers\Member\MyPageController::class, 'accountNumberUpdate'])->name('MemberMyPageAccountNumberUpdatePut');

    // Dealings
    /** 거래 내역 */
    Route::get( 'dealings/manager-details', [App\Http\Controllers\Dealings\ManagerDetailController::class, 'index'])->name('DealingsManagerDetailsGet');
    Route::get( 'dealings/manager-detail/history', [App\Http\Controllers\Dealings\ManagerDetailController::class, 'history'])->name('DealingsManagerDetailHistoryGet');

    // Coin
    /** 코인 관리 */
    Route::get( 'coin/purchase-managers', [App\Http\Controllers\Coin\PurchaseManagerController::class, 'index'])->name('CoinPurchaseManagersGet');
    Route::post( 'coin/purchase-manager', [App\Http\Controllers\Coin\PurchaseManagerController::class, 'store'])->name('CoinPurchaseManagerPost');
    Route::put( 'coin/purchase-manager/cancel/{id}', [App\Http\Controllers\Coin\PurchaseManagerController::class, 'cancel'])->name('CoinPurchaseManagerCancelPut')->where('id', '[0-9]+');
    Route::put( 'coin/purchase-manager/completion/{id}', [App\Http\Controllers\Coin\PurchaseManagerController::class, 'completion'])->name('CoinPurchaseManagerCompletionPut')->where('id', '[0-9]+');

    Route::get( 'coin/sale-managers', [App\Http\Controllers\Coin\SaleManagerController::class, 'index'])->name('CoinSaleManagersGet');
    Route::post( 'coin/sale-manager', [App\Http\Controllers\Coin\SaleManagerController::class, 'store'])->name('CoinSaleManagerPost');
    Route::put( 'coin/sale-manager/cancel/{id}', [App\Http\Controllers\Coin\SaleManagerController::class, 'cancel'])->name('CoinSaleManagerCancelPut')->where('id', '[0-9]+');

    Route::get( 'coin/received-details', [App\Http\Controllers\Coin\ReceivedDetailController::class, 'index'])->name('CoinReceivedDetailsGet');

    Route::get( 'coin/sent-details', [App\Http\Controllers\Coin\SentDetailController::class, 'index'])->name('CoinSentDetailsGet');

    Route::get( 'coin/dealings-fee-details', [App\Http\Controllers\Coin\DealingsFeeDetailController::class, 'index'])->name('CoinDealingsFeeDetailsGet');
});
