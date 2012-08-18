<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $("#menu4").dataTable({
            "bFilter"    : false,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo $sAjaxSource ?>",
            "sColumns"   : "<?php echo implode(',', $select) ?>",
            "iDisplayLength" : 25
        });
    } );
</script>

<h2><?php echo $pageTitle ?></h2>
<hr />
<table id="menu4" class="display">
    <thead>
        <tr>
            <th><?php echo $label['IDPEL'] ?></th>
            <th><?php echo $label['NAMA'] ?></th>
            <th><?php echo $label['JENIS_MK'] ?></th>
            <th><?php echo $label['KDGARDU'] ?></th>
            <th><?php echo $label['NOTIANG'] ?></th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>