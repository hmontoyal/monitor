<?php

namespace app\modules\dashboard\controllers;
use app\modules\dashboard\models\Notas;
use app\modules\dashboard\models\Registros;
use app\modules\areaclientes\models\Ticket;
use app\modules\areaclientes\models\TicketHistorial;
use yii\web\Response;
use yii\web\Controller;
use Yii;

/**
 * Default controller for the `dashboard` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	$this->layout = '../layouts/main';
    		$registros = Registros::find()->indexBy('id')->orderBy(['fecha'=>SORT_DESC])->limit(6)->all();
    	    //var_dump($notas);
        $tickets = Yii::$app->db->createCommand('select t1.*, t2.fecha as fecha_historial, t2.user_id  as user_id , t3.estado, t4.username from ticket t1 join ticket_historial t2 on t1.id = t2.ticket_id join ticket_estado t3 on t3.id = t2.estado_id join user t4 on t2.user_id = t4.id and t4.id ='.Yii::$app->user->identity->id)->queryAll();
        \Yii::$app->getView()->registerJsFile(\Yii::$app->request->BaseUrl . '/js/custom.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
        //var_dump($tickets);
        return $this->render('index', array('registros' => $registros, 'tickets'=> $tickets));
    }

    public function actionCreatenote(){
    	$request = Yii::$app->request;
      		if($request->isAjax){
      			    Yii::$app->response->format = Response::FORMAT_JSON;
      				$nota_n = new Notas();
      				$nota = $_POST['nota'];
      				$titulo = $_POST['nota_titulo'];
      				$nota_n->titulo = $titulo;
      				$nota_n->nota = $_POST['nota'];
      				$nota_n->user_id = Yii::$app->user->identity->id;
      				$nota_n->fecha_creacion = new \yii\db\Expression('NOW()');
      				if($nota_n->save()){
      					echo json_encode(["result"=> true]);
      				}else{
      					echo json_encode(["result"=> false]);
      				}
      				//return response when excecuted!!!!

      		}
    }
}
