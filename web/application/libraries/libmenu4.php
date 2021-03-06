<?php

/**
 * Description of LibMenu4
 *
 * @author spondbob
 */
class LibMenu4 {

    private $ci = null;

    public function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->model(array('dil', 'dph', 'option'));
        $this->ci->load->library(array('LibExport'));
    }

    public function getListMutasi($value = false) {
        if ($value) {
            return array(
                1 => 'A',
                2 => 'D',
            );
        } else {
            return array(
                1 => 'Pasang baru',
                2 => 'Mutasi',
            );
        }
    }

    public function validateInput($input, $list = null) {
        if ($list == null) {
            $list = array(
                'area' => $this->ci->libarea->getList(),
                'mutasi' => $this->getListMutasi(),
            );
        }

        $k = array_keys($list['area']);
        $defaultValue = array(
            'area' => $list['area'][$k[0]],
            'mutasi' => 1,
        );

        foreach (array_keys($input) as $i) {
            if (empty($input[$i]) or !array_key_exists($input[$i], $list[$i])) {
                $input[$i] = $defaultValue[$i];
            }
        }

        return $input;
    }

    private function filter($filter) {
        $mutasi = $this->getListMutasi(true);
        $filter['select'] = (!array_key_exists('select', $filter) ? array('DIL.IDPEL AS IDPEL', 'NAMA', 'TARIF', 'DAYA', 'RPTAG', 'TGLBAYAR', 'PEMKWH') : $filter['select']);
        $filter['order'] = (!array_key_exists('order', $filter) || $filter['order'] == "" ? 'DIL.IDPEL' : $filter['order']);
        $explode = explode(' AS ', $filter['order']);
        $filter['order'] = $explode[0];
        $filter['mutasi'] = $mutasi[$filter['mutasi']];

        return $filter;
    }

    public function getData($filter) {
        $filter = $this->filter($filter);
        return $this->ci->dil->filterMenu4($filter, true);
    }

    public function export($filter) {
        $BLTH = $this->ci->option->getValue('PpobBlTh');
        $fileName = $filter['controller'] . $BLTH . $filter['area'] . $filter['mutasi'] . '.xls';
        $location  = 'static/export/' . strtolower($filter['controller']) . '/' . $BLTH . '/';
        if (!file_exists(FCPATH . $location . $fileName)) {
            $filter = $this->filter($filter);
            $filter['select'] = null;
            $filter['dilBLTH'] = $dilBLTH;
            
            $export = new LibExport();
            $export->fileName = $fileName;
            $export->location = $location;
            $export->BLTH = $BLTH;
            $export->generate($filter);
        }
        redirect(base_url() . $location . $fileName);
    }

}

?>
