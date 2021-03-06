<?php

namespace app\modules\monitoreo\models;

use Yii;

/**
 * This is the model class for table "historial_impresora".
 *
 * @property int $id
 * @property int $id_tecnico
 * @property string $detalle
 * @property int $estado
 * @property string $fecha
 * @property int $id_impresora
 * @property string $n_registro
 * @property int $tipo
 * @property string $adjunto
 * @property int $id_incidente
 *
 * @property Estado $estado0
 * @property Impresoras $impresora
 * @property Incidente $incidente
 * @property User $tecnico
 */
class HImpresora extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'historial_impresora';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tecnico', 'estado', 'id_impresora', 'n_registro', 'tipo'], 'required'],
            [['id_tecnico', 'estado', 'id_impresora', 'tipo', 'id_incidente'], 'integer'],
            [['detalle'], 'string'],
            [['fecha'], 'safe'],
            [['n_registro'], 'string', 'max' => 30],
            [['adjunto'], 'string', 'max' => 1000],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_impresora'], 'exist', 'skipOnError' => true, 'targetClass' => Impresoras::className(), 'targetAttribute' => ['id_impresora' => 'id']],
            [['id_incidente'], 'exist', 'skipOnError' => true, 'targetClass' => Incidente::className(), 'targetAttribute' => ['id_incidente' => 'id']],
            [['id_tecnico'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_tecnico' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tecnico' => 'Id Tecnico',
            'detalle' => 'Detalle',
            'estado' => 'Estado',
            'fecha' => 'Fecha',
            'id_impresora' => 'Id Impresora',
            'n_registro' => 'N Registro',
            'tipo' => 'Tipo',
            'adjunto' => 'Adjunto',
            'id_incidente' => 'Id Incidente',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estado::className(), ['id' => 'estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImpresora()
    {
        return $this->hasOne(Impresoras::className(), ['id' => 'id_impresora']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncidente()
    {
        return $this->hasOne(Incidente::className(), ['id' => 'id_incidente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTecnico()
    {
        return $this->hasOne(User::className(), ['id' => 'id_tecnico']);
    }

    /**
     * {@inheritdoc}
     * @return HImpresoraQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HImpresoraQuery(get_called_class());
    }
}
