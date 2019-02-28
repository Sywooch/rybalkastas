<?php

namespace console\controllers;

use common\models\ChatAnswers;
use common\models\ChatQuestions;
use common\models\SCExpertMessages;

class ChatTransferController extends \yii\console\Controller
{
    public function actionIndex()
    {
        $newQuestionIds = [];
        $oldQs = ChatQuestions::find()->all();
        foreach($oldQs as $q){
            $newQ = new SCExpertMessages;
            $newQ->expert_id = $q->operator_id;
            $newQ->old_user_id = $q->user_id;
            $newQ->message = $q->content;
            $newQ->created_at = $q->date;
            $newQ->parent = 0;
            $newQ->save();
            $newQuestionIds[$q->id] = $newQ->getPrimaryKey();
        }

        $oldAs = ChatAnswers::find()->all();
        foreach($oldAs as $q){
            $newQ = new SCExpertMessages;
            $q_id = $newQuestionIds[$q->question_id];
            $question = SCExpertMessages::findOne($q_id);


            $newQ->expert_id = $question->expert_id;
            $newQ->message = $q->content;
            $newQ->created_at = intval($question->created_at) + 6000;
            $newQ->parent = $q_id;
            $newQ->save(false);
        }
    }
}
