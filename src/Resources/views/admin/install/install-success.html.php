<?php
/**
 * Facebook AWD Template
 *
 * @package FacebookAWD
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
?>
<?php include dirname(__DIR__) . '/header.html.php'; ?>
<div class="facebookAWD">
    <div class="panel panel-success animated fadeInDown">
        <div class="panel-heading">
            Facebook AWD is ready. <img src="<?php echo $application->getIconUrl(); ?>" alt="...">
        </div>
        <table class="table table-hover table-bordered">
            <tr>
                <th colspan="2">App Name</th>
                <td colspan="2"><?php echo $application->getName(); ?></td>
            </tr>
            <tr>
                <th colspan="2">Namespace</th>
                <td colspan="2"><?php echo $application->getNamespace(); ?></td>
            </tr>
            <tr>
                <th colspan="2">Monthly Active Users</th>
                <td><?php echo $application->getMonthlyActiveUsers(); ?></td>
                <td>Rank: <?php echo $application->getMonthlyActiveUsersRank(); ?></td>
            </tr>
            <tr>
                <th colspan="2">Daily Active Users</th>
                <td><?php echo $application->getDailyActiveUsers(); ?></td>
                <td>Rank: <?php echo $application->getDailyActiveUsersRank(); ?></td>
            </tr>
            <tr>
                <th colspan="2">Weekly Active Users</th>
                <td colspan="2"><?php echo $application->getWeeklyActiveUsers(); ?></td>
            </tr>
        </table>
    </div>
    <div style="text-align:center;">
        <a class="btn btn-success btn-lg animated bounceIn" role="button" href="?page=<?php echo $this->container->getSlug(); ?>">Start now !</a>
    </div>
</div>

<?php include dirname(__DIR__) . '/footer.html.php'; ?>
