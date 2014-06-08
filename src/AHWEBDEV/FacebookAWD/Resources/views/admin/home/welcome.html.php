<?php
/**
 * View Admin template
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
?>
<div class="facebookAWD">
    <div class="jumbotron animated bounceIn">
        <h1>Welcome to Facebook AWD !</h1>
        <h4 class="media-heading"><?php echo $application->getName(); ?></h4>
        <table class="table table-condensed table-bordered">
            <tr>
                <th>Namespace</th>
                <td><?php echo $application->getNamespace(); ?></td>
            </tr>
            <tr>
                <th>Monthly Active Users</th>
                <td><?php echo $application->getMonthlyActiveUsers(); ?></td>
            </tr>
        </table>
    </div>
</div>
