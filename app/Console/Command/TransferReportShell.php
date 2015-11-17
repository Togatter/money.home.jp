<?php

class TransferReportShell extends AppShell {

  public $uses = array('TTransferHistory', 'MParameter');



  public function main() {

    // =============================================================================================
    // 各種情報を取得
    // =============================================================================================

    // 今年分の振込情報を取得
    $year = date('Y');
    $transfer_histories = $this->TTransferHistory->findTransferHistory($year);

    // 振込目標額を取得
    $total_price = $this->MParameter->find('first', 
      array(
        'conditions' => array('parameter_name' => 'total_price'),
        'fields'     => array('parameter_value')
      )
    );
    $total_price = $total_price['MParameter']['parameter_value'];

    // 合計振込額を取得
    $total_transfer_price = $this->TTransferHistory->find('first',
      array(
        'conditions' => array('deleted' => 1),
        'fields'     => array('sum(transfer_price) as total_transfer_price')
      )
    );
    $total_transfer_price = $total_transfer_price[0]['total_transfer_price'];

    // 振込残高を取得
    $remaining_price = $total_price - $total_transfer_price;



    // =============================================================================================
    // メール送信処理
    // =============================================================================================

    $email = new CakeEmail('admin');
    $email->to('1970emerson.lake.and.palmer@gmail.com');
    $email->subject($year.'年の振込情報');
    $email->emailFormat('text');
    $email->template('transfer_report');
    $email->viewVars(array(
      'total_price'           => number_format($total_price),
      'total_transfer_price'  => number_format($total_transfer_price),
      'remaining_price'        => number_format($remaining_price),
      'year'                  => $year,
      'transfer_histories'    => $transfer_histories
    ));
    $email->send();
  }
}
