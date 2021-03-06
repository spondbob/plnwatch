<?php

/**
 * Description of Menu4
 *
 * @author spondbob
 */
class Menu4Controller extends CI_Controller {

    private $controller = 'Menu4';
    private $activeUser = null;

    public function __construct() {
        parent::__construct();
        $this->load->library('layout', array('controller' => strtolower($this->controller)));
        $this->load->library(array('LibMenu4', 'LibArea'));
        $this->load->helper(array('form'));
        $this->activeUser = $this->libuser->activeUser;
        $this->_accessRules();
    }

    private function _accessRules() {
        $access = new AccessRule();
        $access->activeRole = $this->activeUser['role'];
        $access->allowedRoles = array(1, 3);
        $access->validate();
    }

    public function index() {
        $this->view();
    }

    public function view() {
		if($this->input->get('download')){
			$this->export();
			exit;
		}
		
        $lib = new LibMenu4();
        $list = array(
            'area' => $this->libarea->getList(),
            'mutasi' => $lib->getListMutasi(),
        );
        $input = array(
            'area' => $this->input->get('area'),
            'mutasi' => $this->input->get('mutasi'),
        );
        $input = $lib->validateInput($input, $list);

        $data = array(
            'pageTitle' => 'Menu 4 - LPB',
            'label' => array_merge($this->dil->attributeLabels(), $this->dph->attributeLabels()),
            'sAjaxSource' => site_url('menu4/data?area=' . $input['area'] . '&mutasi=' . $input['mutasi']),
        );
        foreach (array_keys($input) as $k) {
            $data['dropdownData'][$k] = array(
                'input' => $input[$k],
                'list' => $list[$k],
            );
        }
        $this->layout->render('main', $data);
    }

    public function data() {
        $filter = array(
            'area' => $this->input->get('area'),
            'mutasi' => $this->input->get('mutasi'),
        );
        $filter = $this->libmenu4->validateInput($filter);
        $filter['select'] = array('DIL.IDPEL AS IDPEL', 'NAMA', 'TARIF', 'DAYA', 'RPTAG', 'TGLBAYAR', 'PEMKWH');
        $filter['limit'] = (isset($_GET['iDisplayLength']) && $_GET['iDisplayLength'] != -1 ? intval($_GET['iDisplayLength']) : 25);
        $filter['offset'] = (isset($_GET['iDisplayStart']) ? intval($_GET['iDisplayStart']) : 0);

        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= "`" . $filter['select'][intval($_GET['iSortCol_' . $i])] . "` " .
                            mysql_real_escape_string($_GET['sSortDir_' . $i]);
                }
                if ($i != 0 && $i + 1 == intval($_GET['iSortingCols']))
                    $sOrder .= ', ';
            }
        }

        $filter['order'] = $sOrder;
        $data = $this->libmenu4->getData($filter);
        $aaData = array();
        foreach ($data['data'] as $d) {
            $aaData[] = array(
                $d->IDPEL,
                $d->NAMA,
                $d->TARIF,
                $d->DAYA,
                $d->RPTAG,
                $d->TGLBAYAR,
                $d->PEMKWH,
            );
        }
        $output = array(
            "sEcho" => (isset($_GET['sEcho']) ? intval($_GET['sEcho']) : 1),
            "iTotalRecords" => $data['num'],
            "iTotalDisplayRecords" => $data['num'],
            "aaData" => $aaData,
        );
        echo json_encode($output);
    }

    public function export() {
        $lib = new LibMenu4();
        $filter = array(
            'area' => $this->input->get('area'),
            'mutasi' => $this->input->get('mutasi'),
        );
        $filter = $lib->validateInput($filter);
        $filter['controller'] = $this->controller;
        $lib->export($filter);
    }

}

?>
