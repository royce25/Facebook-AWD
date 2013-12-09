<?php
/**
 * View Admin template
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
?>
<div id="facebookAWD" class="wrap">
    <div class="jumbotron">
        <h1>Facebook AWD is ready.</h1>
        <div class="media well">
            <a class="pull-left" href="#">
                <img class="media-object" src="<?php echo $application->getLogoUrl(); ?>" alt="...">
            </a>
            <div class="media-body">
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
        <p>Now you can learn how to use it, or let Facebook AWD do the job :)</p>
        <p>
            <a class="btn btn-success btn-lg btn-block" role="button" href="?page=FacebookAWD">Start now !</a>
        </p>
    </div>
</div>
