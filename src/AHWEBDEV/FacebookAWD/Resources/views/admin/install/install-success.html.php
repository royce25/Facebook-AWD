<?php

/**
 * View Admin template
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
?>
<?php include dirname(__DIR__) . '/header.html.php'; ?>
<div class="facebookAWD animated fadeInUp">
    <div class="panel panel-success">
        <div class="panel-heading">
            Facebook AWD is ready. <img src="<?php echo $application->getIconUrl(); ?>" alt="...">
        </div>
        <table class="table table-hover table-bordered">
            <tr>
                <th>App Name</th>
                <td><?php echo $application->getName(); ?></td>
            </tr>
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
    <a class="btn btn-success btn-lg btn-block  animated fadeInUp" role="button" href="?page=<?php echo $this->container->getSlug(); ?>">Start now !</a>

</div>

<?php include dirname(__DIR__) . '/footer.html.php'; ?>
