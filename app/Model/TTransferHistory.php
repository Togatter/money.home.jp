<?php
class TTransferHistory extends AppModel {
  public $useTable    = 't_transfer_histories';

  public $validate = array(
    'transfer_price' => array(
      'rule'     => 'numeric',
      'required' => true,
      'message'  => '振込額は必須です。',
    ),
    'transfer_day' => array(
      'rule'     => array('date', 'ymd'),
      'message'  => '存在する日付を入力してください。',
    )
  );

  public function findTransferHistory($this_year) {
    return $this->find('all',
      array(
        'fields'     => array('transfer_price', 'transfer_day'),
        'conditions' => array(
          'deleted' => 1,
          "date_format(transfer_day, '%Y')" => $this_year
        ),
        'order' => 'transfer_day DESC'
      )
    );
  }
}
