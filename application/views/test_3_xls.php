
            <table class="table">
                <tr>
                    <th>Sn. No.</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
                <?php
                foreach ($contact as $key => $value) {
                    ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo ($value['latitude']); ?></td>
                        <td><?php echo ($value['longitude']); ?></td>
                        <td><?php echo $value['date']; ?></td>
                        <td><?php echo $value['time']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <iframe src="https://maps.google.com/maps?q=<?php echo ($value['latitude']);?>,<?php echo ($value['longitude']);?>&z=15&output=embed" width="100%" height="270" frameborder="0" style="border:0"></iframe>

                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>