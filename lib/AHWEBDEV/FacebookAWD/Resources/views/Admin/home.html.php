<?php
/**
 * View Admin template
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
?>
<div>
    <div class="row">

        <div class="col-sm-7">
            <h4>Plugins <a class="btn btn-primary btn-xs" role="button" href="?page=FacebookAWD">Find more...</a></h4>
            <div class="list-group">
                <a href="?page=FacebookAWD&settings" class="list-group-item">
                    <h4 class="list-group-item-heading">Facebook AWD</h4>
                    <p class="list-group-item-text">Base Facebook AWD container</p>
                </a>
            </div>
        </div>
        <div class="col-sm-5">
            <h4>Welcome to Facebook AWD</h4>

            <div class="media well well-sm">
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
            <h4>Be cool, pay me a coffe !</h4>
            <p>
                <a class="btn btn-warning btn-sm" role="button" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZQ2VL33YXHJLC">Donate <span class="glyphicon glyphicon-heart"></span></a>
            </p>
            <h4>Want more ?</h4>
            <p>
                <a class="btn btn-default btn-sm" role="button" href="http://www.facebook-awd.com">Learn more</a>
                <a class="btn btn-info btn-sm" role="button" href="http://www.facebook-awd.com">Documentation</a>
            </p>
        </div>

    </div>
</div>
