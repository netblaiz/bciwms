
                                                <td>
                                                    <div class="dropdown-secondary dropdown">
                                                        <button class="btn btn-primary btn-sm btn-round dropdown-toggle waves-light b-none txt-muted" type="button" id="dropdown8" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Completed Forms</button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdown8" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                            <a class="dropdown-item waves-light waves-effect" href="../filled/questionnaire/'.generateFilledToken($con, date('Y-m-d H:i:s'), $client_idStored, $value['id'], "1", "1", $wms_user_idStored).'" target="_blank"> Questionnaire </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item waves-light waves-effect" href="../filled/guarantor/'.generateFilledToken($con, date('Y-m-d H:i:s'), $client_idStored, $value['id'], "2", "1", $wms_user_idStored).'" target="_blank"> Guarantor</a>
                                                            <a class="dropdown-item waves-light waves-effect" href="../filled/reference/'.generateFilledToken($con, date('Y-m-d H:i:s'), $client_idStored, $value['id'], "3", "1", $wms_user_idStored).'" target="_blank">Reference</a>
                                                            <a class="dropdown-item waves-light waves-effect" href="../filled/company/'.generateFilledToken($con, date('Y-m-d H:i:s'), $client_idStored, $value['id'], "4", "1", $wms_user_idStored).'" target="_blank">Assessment</a>
                                                        </div>
                                                    </div>
                                                </td>