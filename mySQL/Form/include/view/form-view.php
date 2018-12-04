<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Cook-Form-insert</title>
  </head>
  <body>
    <form method="post" action="<?php echo $form->encode($_SERVER['PHP_SELF']); ?>">
      <table>
        <?php if ( $errors ) : ?>
          <tr>
            <td>You need to correct the following errors:</td>
            <td><ul>
              <?php foreach ( $errors as $error ) : ?>
                <li><?php echo $form->encode($error); ?></li>
              <?php endforeach; ?>
            </ul></td>
          </tr>
        <?php endif; ?>
        <tr>
          <td>Dish Name:</td>
          <td><?php echo $form->input('text', ['name' => 'dish_name']); ?></td>
        </tr>
        <tr>
          <td>Price:</td>
          <td><?php echo $form->input('text', ['name' => 'price']); ?></td>
        </tr>
        <tr>
          <td>Spicy:</td>
          <td>
            <?php echo $form->input('checkbox', ['name' => 'is_spicy', 'value' => 'yes']); ?>
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <?php echo $form->input('submit', ['value' => 'Order']); ?>
          </td>
        </tr>
      </table>

    </form>
  </body>
</html>
