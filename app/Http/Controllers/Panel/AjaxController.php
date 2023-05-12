<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Reward;
use App\Models\RewardAccounting;
use App\Models\Role;
use App\Models\Translation\QuizTranslation;
use App\Models\WebinarChapter;
use App\Models\WebinarChapterItem;
use App\User;
use App\Models\Webinar;
use App\Models\QuizzesResult;
use App\Models\QuizzesQuestion;
use App\Models\QuizzesQuestionsAnswer;
use App\Models\QuizzAttempts;
use App\Models\QuizAttemptLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Translation\QuizzesQuestionTranslation;

class AjaxController extends Controller {

    public function helper(Request $request) {
        $attempt_id = $request->post('attempt_id');
        if ($attempt_id > 0) {
            $action = $request->post('action');
            $focus_status = $request->post('focus_status');
            if ($action == 'attempt_status') {
                $attempt_detail = ($focus_status == 'out') ? 'Stopped viewing the Canvas quiz-taking page...' : 'Resumed.';
                $attempt_type = ($focus_status == 'out') ? 'stopped' : 'resumed';
                createAttemptLog($attempt_id, $attempt_detail, $attempt_type);
            }
        }
    }

    /*
     * Get Attempt Logs
     */

    public function quiz_attempts(Request $request) {
        $quiz_result_id = $request->post('quiz_result_id');
        $attempts_ids = QuizzAttempts::select('id')->where('quiz_result_id', $quiz_result_id)
                        ->pluck('id')->toArray();
        $QuizAttemptLogs = QuizAttemptLogs::select('*')->whereIn('attempt_id', $attempts_ids)->get();

        $attempt_logs_list = array();
        if (!empty($QuizAttemptLogs)) {
            foreach ($QuizAttemptLogs as $QuizAttemptLogObj) {
                $attempt_logs_list[$QuizAttemptLogObj->attempt_id][] = $QuizAttemptLogObj;
            }
        }
        $response = '<ul class="quiz-result-logs">';


        if (!empty($attempt_logs_list)) {
            foreach ($attempt_logs_list as $attempt_id => $logs_array) {
                if (!empty($logs_array)) {
                    foreach ($logs_array as $logData) {
                        $response .= '<li>'.$logData->log_detail.'</li>';
                    }
                }
            }
        }
        $response .= '</ul>';
        
        $response = '<div class="quiz-result-logs">
            <div class="logs-heading">
                <h3>Session Information</h3>
            </div>
            <p class="logs-time">
                <strong>Started at</strong>
                Fri Jun 02 2023 13:45:11 GMT-0600 (MDT)
            </p>
            <div class="logs-nav">
                <strong>Attempt</strong>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">1</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">2</button>
                    </li>
                  </ul>
            </div>
            <div class="tab-content">
                <h4>Action Log</h4>
                <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <ul class="logs-list">
                        <li>
                            <span>00:02</span>
                            <strong>Session Started</strong>
                        </li>
                        <li>
                            <span>00:14</span>
                            <strong>Viewed (and possibly read) question <em>#47</em></strong>
                        </li>
                        <li class="close">
                            <span>00:16</span>
                            <strong>Stopped viewing the Canvas quiz-taking page...</strong>
                        </li>
                        <li class="resumed">
                            <span>00:17</span>
                            <strong>Resumed.</strong>
                        </li>
                        <li>
                            <span>00:16</span>
                            <strong>Stopped viewing the Canvas quiz-taking page...</strong>
                        </li>
                        <li>
                            <span>00:16</span>
                            <strong>Resumed.</strong>
                        </li>
                        <li>
                            <span>00:16</span>
                            <strong>Stopped viewing the Canvas quiz-taking page...</strong>
                        </li>
                        <li>
                            <span>00:16</span>
                            <strong>Resumed.</strong>
                        </li>
                        <li>
                            <span>00:16</span>
                            <strong>Stopped viewing the Canvas quiz-taking page...</strong>
                        </li>
                        <li>
                            <span>00:16</span>
                            <strong>Resumed.</strong>
                        </li>
                        <li>
                            <span>00:16</span>
                            <strong>Stopped viewing the Canvas quiz-taking page...</strong>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <ul class="logs-list">
                        <li>
                            <span>00:16</span>
                            <strong>Session Started</strong>
                        </li>
                        <li>
                            <span>00:14</span>
                            <strong>Viewed (and possibly read) question <em>#47</em></strong>
                        </li>
                        <li class="close">
                            <span>00:17</span>
                            <strong>Stopped viewing the Canvas quiz-taking page...</strong>
                        </li>
                        <li class="resumed">
                            <span>00:16</span>
                            <strong>Resumed.</strong>
                        </li>
                        <li>
                            <span>00:16</span>
                            <strong>Stopped viewing the Canvas quiz-taking page...</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>';
        echo $response;exit;
    }

}
