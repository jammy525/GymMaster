<style>
    th {
        font-weight: bold;
    }
</style>
<table border="1" cellpadding="1" width="100%">
    <thead>
    <tr>
        <th>Member ID</th>
        <th style="text-align:center;">Name</th>
        <th style="text-align:center;">Email</th>
        <th style="text-align:center;">Mobile Number</th>
        <th style="text-align:center;">Location</th>
        <th style="text-align:center;">Membership</th>
        <th style="text-align:center;">Status</th>
    </tr>
    </thead>
    <tbody>
      <?Php
     foreach ($users as $row)
     {
      ?>
        <tr>
            <td><?php echo $row['member_id']?></td>
            <td style="text-align:center;"><?php echo $row['first_name']." ".$row['last_name']?></td>
            <td style="text-align:center;"><?php echo $row['email']?></td>
            <td style="text-align:center;"><?php echo $row['mobile']?></td>
            <td style="text-align:center;"><?php echo $this->Gym->get_member_report_location($row['associated_licensee'])?></td>
            <td style="text-align:center;"><?php echo $this->Gym->get_member_report_plan($row['selected_membership'])?></td>
             <td style="text-align:center;"><?php echo $this->Gym->get_member_report_plan_status($row['selected_membership'],$row['id'])?></td>
        </tr>
     <?php } ?>
    </tbody>
</table>