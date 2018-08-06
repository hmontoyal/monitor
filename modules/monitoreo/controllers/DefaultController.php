<?php

namespace app\modules\monitoreo\controllers;

use yii\web\Controller;
use yii\web\Response;
use app\modules\monitoreo\models\Centro;
use app\modules\monitoreo\models\Marca;
use app\modules\monitoreo\models\Modelo;
use app\modules\monitoreo\models\Impresoras;
use app\modules\monitoreo\models\Himpresora;
use app\modules\monitoreo\models\User;
use app\modules\monitoreo\models\Estado;
use app\modules\monitoreo\models\Ubicacion;
use Yii;

/**
 * Default controller for the `monitor` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $imp = Impresoras::find()->where(['deshabilitada' => 0 ])->indexBy('id')->all();
        return $this->render('index', array('imp' => $imp));
    }

    public function actionAgregar(){
    	 $query  = Centro::find()->orderBy('nom_cc')->all();
         $marca  = Marca::find()->orderBy('marca')->all();
         $modelo = Modelo::find()->orderBy('modelo')->all();
          //var_dump($query);
    	return $this->render('agregar',['ccostos' => $query, 'marcas' => $marca, 'modelo' => $modelo]);
    }

    public function actionPrinteradd(){
      $request = Yii::$app->request;
      if($request->isAjax){
          $data = $_POST;
          $imp = new Impresoras();
          $imp->serie = $data['serie'];
          $imp->codigo = $data['codigo'];
          $imp->serie = $data['serie'];
          $imp->modelo = $data['impresora'];
          $imp->centro_costo = $data['centrocosto'];
          $imp->contacto = $data['contacto'];
          $imp->telefono = $data['telefono'];
          $imp->email = $data['email'];
          $imp->observaciones = $data['observacion'];
          $imp->ubicacion = $data['ubicacion'];
          $imp->oficina = $data['oficina'];
          $imp->piso = $data['piso'];
          $imp->deshabilitada = 0;
          $imp->fecha = new \yii\db\Expression('NOW()');

          Yii::$app->response->format = Response::FORMAT_JSON;

           if($imp->insert()){

                 $u = new Ubicacion();
                 $u->impresora = $imp->id;
                 $u->fecha = new \yii\db\Expression('NOW()');
                 $u->oficina = $data['oficina'];
                 $u->ubicacion = $data['ubicacion'];
                 $u->piso = $data['piso'];
                 if($u->insert()){
                    echo json_encode(["success"=> true]);
                 }else{
                 // var_dump($u->getErrors());
                 }
                
           }else{
                    echo json_encode(["success"=> false]);
                    
           }



      }
    }

    public function actionAddhistory(){
          $request = Yii::$app->request;
          if($request->isAjax){
          $data = $_POST;

          $h = new Himpresora();
          $imp = Impresoras::find()->where(['id' => $data['id_impresora']])->one();
          $transaction = Himpresora::getDb()->beginTransaction();

          try {
                    $h->estado = $data['estado'];
                    $h->id_impresora = $data['id_impresora'];
                    $h->fecha = $data['fecha'];
                    $h->id_tecnico = Yii::$app->user->identity->id;
                    $h->detalle = $data['observaciones'];
                    $h->tipo = $data['tipo'];
                    $h->n_registro = $data['registro'];
                    $result = false;
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    //si es un cambio de ubicacion
                    if($data['estado'] == 0 ){
                           //agregar un nuevo historial de ubicacion
                            $u = new Ubicacion();
                            $u->ubicacion = $data['ubicacion'];
                            $u->oficina = $data['oficina'];
                            $u->piso = $data['piso'];                  
                            $u->impresora = $data['id_impresora'];
                            $u->fecha = $data['fecha'];
                            
                            $imp->ubicacion = $data['ubicacion'];
                            $imp->oficina = $data['oficina'];
                            $imp->piso = $data['piso'];
                            $u->insert();
                            $imp->update();
                            $h->insert();

                            $transaction->commit();
                            $result = true;

              }else{

                     $result = $h->insert();
                      $transaction->commit();

              }
                     echo json_encode(array('success' => $result));

                } catch(\Exception $e) {

                    $transaction->rollBack();
                     throw $e;
                    } catch(\Throwable $e) {

                    $transaction->rollBack();
                    throw $e;
            }

        



      }
    }


    public function actionDetalleprinter(){
       if(isset($_GET['id']) && is_numeric($_GET['id'])){
         $imp = Impresoras::find()->where(['id' => $_GET['id']])->one();
         $estados = Estado::find()->indexBy('id')->all();
         $detalle = Himpresora::find()->where(['id_impresora' => $_GET['id']])->all();
         $ubicaciones = Ubicacion::find()->where(['impresora' => $_GET['id']])->all();
           return $this->render('detalle', array('detalle' => $detalle, 'imp' => $imp,'estados' => $estados, 'ubicaciones' => $ubicaciones));
       }else{

       }
       
    }

    public function actionDetallePrinterAjax(){
         $request = Yii::$app->request;
         if($request->isAjax){
           $data = $_POST;
            $imp =  Impresoras::find()->where(['id' => $data['id']])->one();
            $cc = $imp->getCentroCosto()->one();
              $modelo = $imp->getModelo0()->one();
            $marca = $modelo->getMarca0()->one();
             $detalle = Himpresora::find()->where(['id_impresora' => $data['id']])->orderBy(['id' => SORT_ASC])->all();
          
           // var_dump($cc);
            return $this->renderPartial('detalle_ajax', array('imp' => $imp, 'cc' => $cc, 'ma' => $marca, 'mo' =>$modelo, 'detalle' => $detalle));


      }
    }

        public function actionPrinterEditAjax(){
         $request = Yii::$app->request;
         if($request->isAjax){
           $data = $_POST;
            $imp =  Impresoras::find()->where(['id' => $data['id']])->one();
             $query  = Centro::find()->orderBy('nom_cc')->all();
             $marca  = Marca::find()->orderBy('marca')->all();
             $modelo = Modelo::find()->orderBy('modelo')->all();
          //var_dump($query);
        return $this->renderPartial('edit_ajax',['imp' => $imp, 'ccostos' => $query, 'marcas' => $marca, 'modelo' => $modelo]);



      }
    }


    public function actionPrinterUpdate(){
         $request = Yii::$app->request;
         Yii::$app->response->format = Response::FORMAT_JSON;
         if($request->isAjax){
            $data = $_POST;
            $imp =  Impresoras::find()->where(['id' => $data['id']])->one();
            if($imp){
                $imp->serie = $data['serie'];
                 $imp->codigo = $data['codigo'];
                  $imp->centro_costo = $data['centrocosto'];
                   $imp->contacto = $data['contacto'];
                    $imp->telefono = $data['telefono'];
                     $imp->email = $data['email'];
                      $imp->modelo = $data['impresora'];
                       $imp->observaciones = $data['observacion'];

                if ($imp->update() !== false) {
                        echo json_encode(["success"=> false ]);
                        } else {
                         echo json_encode(["success"=> false ]);
                        }
                // echo json_encode(["success"=> true]);
            }else{
                echo json_encode(["success"=> false ]);
            }
      }
    }

    public function actionDeleteprinter(){
         $request = Yii::$app->request;
         Yii::$app->response->format = Response::FORMAT_JSON;
         if($request->isAjax){
            $data = $_POST;
            $imp =  Impresoras::find()->where(['id' => $data['id']])->one();
            if($imp){
                $imp->deshabilitada = 1;
                if($imp->update() != false){
                  echo json_encode(["success"=> true]);
                }else{
                   echo json_encode(["success"=> false]);
                }
                // echo json_encode(["success"=> true]);
            }else{
                echo json_encode(["success"=> false ]);
            }
      }
    }


   public function actionPrinterEdit(){
            $request = Yii::$app->request;
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isAjax){
            $data = $_POST;
            $imp =  Impresoras::find()->where(['id' => $data['id']])->one();
            if($imp){
                $imp->serie = $data['serie'];
                $imp->codigo = $data['codigo'];
                //$imp->modelo = $data['impresora']
                $imp->centro_costo = $data['centrocosto'];
                $imp->contacto = $data['contacto'];
                $imp->telefono = $data['telefono'];
                $imp->email = $data['email'];
                $imp->observaciones = $data['observacion'];
                // $imp->ubicacion = $data['ubicacion'];
                // $imp->oficina = $data['oficina'];
                // $imp->piso = $data['piso'];

               if($imp->update() !== false){
                    echo json_encode(["success" => true]);
               }else{
                    echo json_encode(["success"=> false]);
               }

            }else{
                echo json_encode(["success"=> false ]);
            }
      }
   }








    
}