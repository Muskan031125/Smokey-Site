<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8"/>
  <title>Welcome to <?= esc($brand) ?></title>
</head>
<body style="margin:0;padding:0;background:#f7f3ec;font-family:Georgia,'Times New Roman',serif;color:#0f0f10;">
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f7f3ec;padding:40px 20px;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" border="0" style="background:#ffffff;border:1px solid #e4e4e7;">

          <!-- Header -->
          <tr>
            <td align="center" style="background:#0f0f10;padding:40px 20px;">
              <div style="font-family:Georgia,serif;font-size:36px;letter-spacing:8px;color:#f7f3ec;">
                <?= esc($brand) ?>
              </div>
              <div style="font-size:10px;letter-spacing:4px;text-transform:uppercase;color:#b8935a;margin-top:8px;">
                A Private Digital Catalog
              </div>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding:50px 50px 30px;">
              <p style="font-size:14px;letter-spacing:4px;text-transform:uppercase;color:#b8935a;margin:0 0 12px;">
                You're Approved
              </p>
              <h1 style="font-family:Georgia,serif;font-size:36px;font-weight:normal;margin:0 0 24px;color:#0f0f10;line-height:1.1;">
                Welcome,<br/><em style="color:#b8935a;"><?= esc($name) ?></em>
              </h1>
              <p style="font-size:15px;line-height:1.7;color:#333;margin:0 0 20px;">
                Thank you for your interest in <?= esc($brand) ?>. Our team has reviewed your request,
                and we're delighted to grant you access to our private digital catalog.
              </p>
              <p style="font-size:15px;line-height:1.7;color:#333;margin:0 0 30px;">
                You'll find curated collections of fine diamond jewellery, each with live pricing
                and high-resolution media — available exclusively to approved clients.
              </p>

              <!-- Credentials -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f7f3ec;border:1px solid #e4e4e7;margin:30px 0;">
                <tr>
                  <td style="padding:30px;">
                    <p style="font-size:10px;letter-spacing:4px;text-transform:uppercase;color:#b8935a;margin:0 0 16px;">
                      Your Temporary Credentials
                    </p>
                    <p style="font-size:12px;color:#6b6b6b;margin:0 0 4px;text-transform:uppercase;letter-spacing:1px;">Email</p>
                    <p style="font-size:16px;margin:0 0 16px;font-family:'Courier New',monospace;"><?= esc($email) ?></p>
                    <p style="font-size:12px;color:#6b6b6b;margin:0 0 4px;text-transform:uppercase;letter-spacing:1px;">Temporary Password</p>
                    <p style="font-size:18px;margin:0;font-family:'Courier New',monospace;color:#8f6f3d;font-weight:bold;letter-spacing:2px;"><?= esc($password) ?></p>
                  </td>
                </tr>
              </table>

              <!-- CTA -->
              <table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:30px auto;">
                <tr>
                  <td style="background:#0f0f10;">
                    <a href="<?= esc($loginUrl) ?>" style="display:inline-block;padding:18px 48px;color:#f7f3ec;text-decoration:none;font-size:11px;letter-spacing:4px;text-transform:uppercase;">
                      Sign In Now
                    </a>
                  </td>
                </tr>
              </table>

              <!-- Security note -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#fffbeb;border-left:3px solid #b8935a;margin:30px 0 0;">
                <tr>
                  <td style="padding:20px;">
                    <p style="font-size:12px;color:#6b6b6b;margin:0;line-height:1.6;">
                      <strong style="color:#8f6f3d;">For your security:</strong> You will be asked
                      to change this temporary password the first time you sign in. Please do not
                      share these credentials with anyone.
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="background:#0f0f10;padding:30px;text-align:center;">
              <p style="font-size:10px;letter-spacing:2px;color:#6b6b6b;margin:0;text-transform:uppercase;">
                © <?= date('Y') ?> <?= esc($brand) ?> · By Invitation Only
              </p>
              <p style="font-size:11px;color:#6b6b6b;margin:8px 0 0;">
                If you did not request access, please ignore this email.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
