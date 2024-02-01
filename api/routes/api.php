<?php

use App\Http\Controllers\ApplicantGuidesController;
use App\Http\Controllers\ApplicationProcessController;
use App\Http\Controllers\ARController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\BroadcastMessageController;
use App\Http\Controllers\CompetencyController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ComplaintTypeController;
use App\Http\Controllers\DashboardControler;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FeesAndDuesController;
use App\Http\Controllers\FsdApplicationController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\MbgApplicationController;
use App\Http\Controllers\Meg2ApplicationController;
use App\Http\Controllers\MegApplicationController;
use App\Http\Controllers\MemberCategoryController;
use App\Http\Controllers\MemberGuidesController;
use App\Http\Controllers\MembershipApplicationController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RegulatorsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SanctionsController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [UsersController::class, 'login']);
    Route::post('/register', [UsersController::class, 'register']);

    Route::prefix('password')->group(function () {
        Route::post('/change', [PasswordController::class, 'changePassword'])->middleware('throttle:10,5');
        Route::post('/set', [PasswordController::class, 'setPassword'])->middleware('throttle:10,5');

        Route::prefix('reset')->group(function () {
            Route::post('/initiate', [PasswordController::class, 'forgotPassword']);
            Route::post('/otp', [PasswordController::class, 'validateForgotPasswordOtp'])->middleware('throttle:10,5');
            Route::post('/complete', [PasswordController::class, 'resetPassword'])->middleware('passwordReset');
        });
    });
});

Route::get('/nationalities', [NationalityController::class, 'index']);
Route::get('/positions', [PositionController::class, 'index']);
Route::get('/ar_roles', [RoleController::class, 'user_roles']);
Route::get('/admin_roles', [RoleController::class, 'admin_roles']);
Route::get('/categories', [MemberCategoryController::class, 'index']);
Route::post('/category/positions', [MemberCategoryController::class, 'positions']);
Route::get('/complaint-types', [ComplaintTypeController::class, 'index']);

Route::middleware('auth')->group(function () {

    Route::get('/system/configs', [SystemController::class, 'index']);
    //
    Route::group(['prefix' => 'complaint'], function () {
        Route::post('/store', [ComplaintController::class, 'store']);
        Route::get('/', [ComplaintController::class, 'index']);
    });

    //
    Route::group(['prefix' => 'user'], function () {
        Route::get('/logs', [AuditController::class, 'userLog']);
    });

    Route::middleware('authRole:' . Role::MSG . ',' . Role::MEG . ',' . Role::FSD . ',' . Role::MBG . ',' . Role::BLG . ',' . Role::MEG2 . ',' . Role::BIG . ',' . Role::HELPDESK )->group(function () {
        Route::get('admin/dashboard', [DashboardControler::class, 'adminDashboard']);

        // List AR For Admins
        Route::group(['prefix' => 'meg/ar'], function () {
            Route::get('/list', [ARController::class, 'listMEG']);
            Route::get('/transfer', [ARController::class, 'listTransferMEG']);
        });

        Route::group(['prefix' => 'membership/application'], function () {
            Route::get('/all_institutions', [ApplicationProcessController::class, 'all_institutions']);
        });

    });

    Route::middleware('authRole:' . Role::ARAUTHORISER . ',' . Role::ARINPUTTER)->group(function () {
        Route::get('ar/dashboard', [DashboardControler::class, 'arDashboard']);
    });

    // MEG ROUTES
    Route::middleware('authRole:' . Role::MEG)->group(function () {
        // complaint
        Route::group(['prefix' => 'complaint'],  function () {
            Route::post('/feedback', [ComplaintController::class, 'feedback']);
            Route::post('/status', [ComplaintController::class, 'changeStatus']);
            Route::get('/all', [ComplaintController::class, 'allComplaints']);
        });
        // audit
        Route::group(['prefix' => 'audits'],  function () {
            Route::get('/logs', [AuditController::class, 'index']);
        });
        //
        Route::group(['prefix' => 'meg/ar'],  function () {

            Route::post('/process-add/{ARUser}', [ARController::class, 'processAddByMEG']);
            Route::post('/process-transfer/{record}', [ARController::class, 'processTransferByMEG']);
        });
        // broadcast
        Route::group(['prefix' => 'broadcasts'],  function () {
            Route::get('/view-messages', [BroadcastMessageController::class, 'index']);
            Route::post('/create-message', [BroadcastMessageController::class, 'store']);
        });

        // institutions
        Route::group(['prefix' => 'institution'],  function () {
            Route::get('/list', [InstitutionController::class, 'listInstitution']);
        });
        // Membership Category
        Route::group(['prefix' => 'membership/category'],  function () {
            Route::get('/list', [MemberCategoryController::class, 'listAll']);
            Route::post('/create', [MemberCategoryController::class, 'addCategory']);
            Route::post('/mapToPositions', [MemberCategoryController::class, 'mapToPositions']);
            Route::post('/unlinkFromPositions', [MemberCategoryController::class, 'unlinkFromPositions']);
            Route::post('/update/{category}', [MemberCategoryController::class, 'updateCategory']);
            Route::post('/update-status/{category}', [MemberCategoryController::class, 'changeStatusCategory']);
        });
        // Positions
        Route::group(['prefix' => 'meg/position'],  function () {
            Route::get('/list', [PositionController::class, 'listAll']);
            Route::post('/create', [PositionController::class, 'addPosition']);
            Route::post('/mapToCategories', [PositionController::class, 'mapToCategories']);
            Route::post('/unlinkFromCategories', [PositionController::class, 'unlinkFromCategories']);
            Route::post('/update/{position}', [PositionController::class, 'updatePosition']);
            Route::post('/update-status/{position}', [PositionController::class, 'changeStatusPosition']);
        });
        // Complaint
        Route::group(['prefix' => 'meg/complain-type'],  function () {
            Route::get('/list', [ComplaintTypeController::class, 'listAll']);
            Route::post('/create', [ComplaintTypeController::class, 'addComplainType']);
            Route::post('/update/{complainType}', [ComplaintTypeController::class, 'updateComplainType']);
            Route::post('/update-status/{complainType}', [ComplaintTypeController::class, 'changeStatusComplainType']);
        });
        // regulators
        Route::group(['prefix' => 'meg/regulators'],  function () {
            Route::get('/view_all', [RegulatorsController::class, 'index']);
            Route::post('/create', [RegulatorsController::class, 'store']);
            Route::post('/update/{id}', [RegulatorsController::class, 'update']);
            Route::post('/update-status/{id}', [RegulatorsController::class, 'updateStatus']);
        });
        // sanctions
        Route::group(['prefix' => 'disciplinary-sanctions'],  function () {
            Route::get('/list_all', [SanctionsController::class, 'index']);
        });
        // competency
        Route::group(['prefix' => 'meg/competency-framework'],  function () {
            Route::get('/list-all', [CompetencyController::class, 'listAll']);
            Route::get('/list-compliant-ars/{id}', [CompetencyController::class, 'listCompliantArs']);
            Route::get('/list-non-complaint-ars/{id}', [CompetencyController::class, 'listNonCompliantArs']);
            Route::get('/list-all-compliant-ars', [CompetencyController::class, 'listAllCompliantArs']);
            Route::get('/list-all-non-complaint-ars', [CompetencyController::class, 'listAllNonCompliantArs']);
            Route::post('/create', [CompetencyController::class, 'store']);
            Route::post('/update/{id}', [CompetencyController::class, 'update']);
            Route::post('/update-status/{id}', [CompetencyController::class, 'updateStatus']);
        });
        // fees and dues
        Route::group(['prefix' => 'meg/fees-and-dues'],  function () {
            Route::get('/list_all', [FeesAndDuesController::class, 'listAll']);
            Route::post('/create', [FeesAndDuesController::class, 'store']);
            Route::post('/update/{id}', [FeesAndDuesController::class, 'update']);
            Route::post('/update-status/{id}', [FeesAndDuesController::class, 'updateStatus']);
        });
        // applicant guides
        Route::group(['prefix' => 'meg/applicant-guides'],  function () {
            Route::get('/list-all', [ApplicantGuidesController::class, 'listAll']);
            Route::post('/create', [ApplicantGuidesController::class, 'store']);
            Route::post('/update/{id}', [ApplicantGuidesController::class, 'update']);
            Route::post('/update-status/{id}', [ApplicantGuidesController::class, 'updateStatus']);
        });
        // membership guides
        Route::group(['prefix' => 'meg/member-guides'],  function () {
            Route::get('/list-all', [MemberGuidesController::class, 'listAll']);
            Route::post('/create', [MemberGuidesController::class, 'store']);
            Route::post('/update/{id}', [MemberGuidesController::class, 'update']);
            Route::post('/update-status/{id}', [MemberGuidesController::class, 'updateStatus']);
        });
    });

    // CCO ROUTES
    Route::middleware('cco')->group( function () {
        // sanctions
        Route::group(['prefix' => 'disciplinary-sanctions'], function () {
            Route::get('/my_sanctions', [SanctionsController::class, 'mySanction']);
            Route::post('/create', [SanctionsController::class, 'store']);
        });

        // competency
        Route::group(['prefix' => 'cco/competency'], function () {
            Route::get('/ar', [CompetencyController::class, 'listARCompetencies']);
            Route::post('/status', [CompetencyController::class, 'statusCompetency']);
        });
    });

    //MSG ROUTES

    //FSD ROUTES
    Route::middleware('authRole:' . Role::FSD)->group(function () {
        Route::group(['prefix' => 'membership/application/fsd'], function () {
            Route::get('/institutions', [FsdApplicationController::class, 'institutions']);
            Route::post('/payment-information', [FsdApplicationController::class, 'paymentInformation']);
            Route::post('/latest-payment-evidence', [FsdApplicationController::class, 'latestEvidence']);
            Route::post('/payment-details', [FsdApplicationController::class, 'paymentReviewDetails']);
            Route::post('/payment-review', [FsdApplicationController::class, 'fsdReview']);
        });
    });

    //MBG ROUTES
    Route::middleware('authRole:' . Role::MBG)->group(function () {
        Route::group(['prefix' => 'membership/application/mbg'],  function () {
            Route::get('/institutions', [MbgApplicationController::class, 'institutions']);
            Route::post('/upload-concession', [MbgApplicationController::class, 'concession']);
            Route::post('/payment-information', [MbgApplicationController::class, 'paymentInformation']);
            Route::post('/latest-payment-evidence', [MbgApplicationController::class, 'latestEvidence']);
            Route::post('/payment-details', [MbgApplicationController::class, 'paymentReviewDetails']);
            Route::post('/fsd-review-summary', [MbgApplicationController::class, 'fsdReviewSummary']);
            Route::post('/review', [MbgApplicationController::class, 'mbgReview']);
        });
    });

    //MEG ROUTES
    Route::middleware('authRole:' . Role::MEG)->group(function () {
        Route::group(['prefix' => 'membership/application/meg'], function () {
            Route::get('/institutions', [MegApplicationController::class, 'institutions']);
            Route::post('/review', [MegApplicationController::class, 'megReview']);
        });
    });

    //MEG2 ROUTES
    Route::middleware('authRole:' . Role::MEG2)->group(function () {
        Route::group(['prefix' => 'membership/application/meg2'],  function () {
            Route::get('/institutions', [Meg2ApplicationController::class, 'institutions']);
            Route::post('/review', [Meg2ApplicationController::class, 'meg2Approval']);
        });
    });

    // AR ROUTES
    Route::middleware('authRole:' . Role::ARAUTHORISER . ',' . Role::ARINPUTTER)->group(function () {
        Route::group(['prefix' => 'ar'], function () {
            Route::get('/list', [ARController::class, 'list']);
            Route::get('/search', [ARController::class, 'search']);
            Route::get('/view/{ARUser}', [ARController::class, 'view']);
            Route::post('/add', [ARController::class, 'add']);
            Route::post('/update/{ARUser}', [ARController::class, 'update']);
            Route::post('/cancel-update/{ARUser}', [ARController::class, 'cancelUpdate']);
            Route::post('/process-update/{ARUser}', [ARController::class, 'processUpdate']);

            Route::get('/transfer', [ARController::class, 'listTransfer']);
            Route::get('/change-status', [ARController::class, 'listStatusChange']);

            Route::post('/transfer/{ARUser}', [ARController::class, 'transfer']);
            Route::post('/process-transfer/{record}', [ARController::class, 'processTransfer']);

            Route::post('/change-status/{ARUser}', [ARController::class, 'changeStatus']);
            Route::post('/process-change-status/{record}', [ARController::class, 'processChangeStatus']);
        });
        //
        Route::group(['prefix' => 'regulators'], function () {
            Route::get('/list', [RegulatorsController::class, 'list']);
        });
        //
        Route::group(['prefix' => 'competency'], function () {
            Route::get('/list-active', [CompetencyController::class, 'listActive']);
            Route::post('/submit-competency', [CompetencyController::class, 'submitCompetency']);
        });
        Route::group(['prefix' => 'membership/application'], function () {
            Route::get('/', [MembershipApplicationController::class, 'application']);
            Route::get('/fields', [MembershipApplicationController::class, 'getField']);
            Route::get('/detail', [MembershipApplicationController::class, 'getDetail']);
            Route::get('/field/option', [MembershipApplicationController::class, 'getFieldOption']);
            Route::get('/extra', [MembershipApplicationController::class, 'getFieldExtra']);
            Route::post('/upload', [MembershipApplicationController::class, 'uploadField']);
            Route::post('/invoice/download', [MembershipApplicationController::class, 'downloadInvoice']);
            Route::post('/upload-payment-proof', [MembershipApplicationController::class, 'uploadProofOfPayment']);
            Route::post('/complete', [MembershipApplicationController::class, 'complete']);
        });
    });
    //
    Route::group(['prefix' => 'user'], function () {
        Route::get('/authorisers', [UserController::class, 'list_ar_authorisers']);
    });
    //
    Route::group(['prefix' => 'events'], function () {
        Route::get('/', [EventController::class, 'list']);
        Route::get('/view/{event}', [EventController::class, 'view']);
        Route::get('/registered', [EventController::class, 'myRegisteredEvents']);
        Route::get('/invited', [EventController::class, 'myInvitedEvents']);

        // Route::middleware('authRole:' . Role::MEG)->group(function () {
        Route::post('/add', [EventController::class, 'add']);
        Route::post('/update/{event}', [EventController::class, 'update']);
        Route::post('/update-invited/{event}', [EventController::class, 'updateInvitePositions']);
        Route::post('/delete/{eventID}', [EventController::class, 'delete']);

        Route::post('/send-certificates', [EventController::class, 'sendCertificates']);
        Route::get('/preview-certificate/{event}', [EventController::class, 'certificateSample'])->name('preview.certificate');

        Route::middleware('authRole:' . Role::MEG . ',' . Role::FSD)->group(function () {
            Route::get('/registrations/{event}', [EventController::class, 'eventRegistrations']);
            Route::post('/registration-update-status/{eventReg}', [EventController::class, 'approveEventRegistration']);
        });

        Route::middleware('authRole:' . Role::ARAUTHORISER . ',' . Role::ARINPUTTER)->group(function () {
            Route::post('/register/{event}', [EventController::class, 'register']);
            Route::post('/update-pop/{eventReg}', [EventController::class, 'registerUpdatePOP']);
        });
    });
    //
    Route::group(['prefix' => 'fees-and-dues'], function () {
        Route::get('/current', [FeesAndDuesController::class, 'listCurrent']);
    });
    //
    Route::group(['prefix' => 'applicant-guide'], function () {
        Route::get('/current', [ApplicantGuidesController::class, 'listCurrent']);
    });
    //
    Route::group(['prefix' => 'member-guide'], function () {
        Route::get('/current', [MemberGuidesController::class, 'listCurrent']);
    });
});

Route::get('execute-commands', [SystemController::class, 'executeCommands'])->name('executeCommands');
Route::get('clear-model/{model}', [SystemController::class, 'clearModel'])->name('clearModel');
Route::get('refresh-database', [SystemController::class, 'refreshDatabase'])->name('refreshDatabase');

Route::get('cert-sample/{event}', [EventController::class, 'certificateSample'])->name('clearModel');
Route::get('cert-sample-download/{event}', [EventController::class, 'certificateSampleDownload'])->name('clearModel');
