<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Cook-Form</title>
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
          <td>Your Name:</td>
          <td><?php echo $form->input('text', ['name' => 'name']); ?></td>
        </tr>
        <tr>
          <td>Size:</td>
          <td>
            <?php echo $form->input('radio', ['name' => 'size', 'value' => 'small']); ?>small<br>
            <?php echo $form->input('radio', ['name' => 'size', 'value' => 'medium']); ?>medium<br>
            <?php echo $form->input('radio', ['name' => 'size', 'value' => 'large']); ?>large<br>
          </td>
        </tr>
        <tr>
          <td>Pick one sweet item:</td>
          <td>
            <?php echo $form->select($GLOBALS['sweets'], ['name' => 'sweet']); ?>
          </td>
        </tr>
        <tr>
          <td>Pick two main dishes:</td>
          <td>
            <?php
              echo $form->select(
                            $GLOBALS['main_dishes'],
                            [
                              'name'     => 'main_dish',
                              'multiple' => true
                            ]);
            ?>
          </td>
        </tr>
        <tr>
          <td>Do you want your order delivered?</td>
          <td>
            <?php echo $form->input('checkbox', ['name' => 'delivery', 'value' => 'yes']); ?>Yes
          </td>
        </tr>
        <tr>
          <td>
            Enter any special instructions.<br>
            If you want your order delivered, put your address here:
          </td>
          <td>
            <?php echo $form->textarea(['name' => 'comments']); ?>
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
