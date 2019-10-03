<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Simple Transactional Email</title>
    <style>
    /* -------------------------------------
        INLINED WITH htmlemail.io/inline
    ------------------------------------- */
    /* -------------------------------------
        RESPONSIVE AND MOBILE FRIENDLY STYLES
    ------------------------------------- */
    @media only screen and (max-width: 620px) {
      table[class=body] h1 {
        font-size: 28px !important;
        margin-bottom: 10px !important;
      }
      table[class=body] p,
            table[class=body] ul,
            table[class=body] ol,
            table[class=body] td,
            table[class=body] span,
            table[class=body] a {
        font-size: 16px !important;
      }
      table[class=body] .wrapper,
            table[class=body] .article {
        padding: 10px !important;
      }
      table[class=body] .content {
        padding: 0 !important;
      }
      table[class=body] .container {
        padding: 0 !important;
        width: 100% !important;
      }
      table[class=body] .main {
        border-left-width: 0 !important;
        border-radius: 0 !important;
        border-right-width: 0 !important;
      }
      table[class=body] .btn table {
        width: 100% !important;
      }
      table[class=body] .btn a {
        width: 100% !important;
      }
      table[class=body] .img-responsive {
        height: auto !important;
        max-width: 100% !important;
        width: auto !important;
      }
    }

    /* -------------------------------------
        PRESERVE THESE STYLES IN THE HEAD
    ------------------------------------- */
    @media all {
      .ExternalClass {
        width: 100%;
      }
      .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
        line-height: 100%;
      }
      .apple-link a {
        color: inherit !important;
        font-family: inherit !important;
        font-size: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
        text-decoration: none !important;
      }
      .btn-primary table td:hover {
        background-color: #34495e !important;
      }
      .btn-primary a:hover {
        background-color: #34495e !important;
        border-color: #34495e !important;
      }
      .btn-orange table td:hover {
        background-color: #ff6300 !important;
      }
      .btn-orange a:hover {
        background-color: #ff6300 !important;
        border-color: #ff6300 !important;
      }
    }
    </style>
  </head>
  <body class="" style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
    <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">
      <tr>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
        <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
          <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">

            <!-- START CENTERED WHITE CONTAINER -->
            <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">Email Confirmation</span>
            <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">

              <!-- START MAIN CONTENT AREA -->
             <tr>
                  <td class="wrapper" style="width: 100%">
                    <img src="{{ url('/img/logo/agx_logo_dark.jpg') }}" style="width:100%">
                  </td>
             </tr>
              <tr>
                <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px 50px;">
                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                    <tr>
                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                        <p style="font-family: sans-serif; font-size: 30px; font-weight: normal; margin: 0; Margin-bottom: 15px; color: #f57321">Dear {{ $data['name'] }}</p>
                        <p style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;">You told us you forgot your password. If you really did, please click the Reset Password button below to reset your password. The link will expire in 2 hours.</p>
                        
                        <table border="0" cellpadding="0" cellspacing="0" class="btn btn-orange" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                          <tbody>
                            <tr>
                              <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                  <tbody>
                                    <tr>
                                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #f57321; border-radius: 0px; text-align: center;"> <a href="{{ url('/api/authentication/password/reset/'.$data['token']) }}" target="_blank" style="display: inline-block; color: #ffffff; background-color: #f57321; border: solid 1px #f57321; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #f57321;width:100%">Reset Password</a> </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <p style="font-family: sans-serif; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Kind regards,<br/>Australian Stock Market - Trade Talk</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

            <!-- END MAIN CONTENT AREA -->
            </table>

            <!-- START FOOTER -->
            <div class="footer" style="clear: both; Margin-top: 0px; text-align: center; width: 100%; background: #000">
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                 <tr>
                    <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 25px; font-size: 12px; color: #999999; text-align: center;">
                       <a href="{{ url('') }}" style="text-decoration: underline; color: #999999; font-size: 12px; text-align: center;">
                           <img src="{{ url('/img/logo/agx_logo_dark.jpg') }}" style="width:30%;margin:auto;">
                       </a>
                    </td>
                </tr>
                <tr>
                    <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 0px; padding-top: 0; font-size: 12px; color: #999999; text-align: center;">
                       <hr style="width: 80%; border-width : 0.3px" />
                    </td>
                </tr>
                <tr>
                  <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 25px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                    <div>
                         <a href="https://twitter.com/HotCopper">
                           <img src="{{ url('/img/social-media-logo/twitter.png') }}"  style="width: 34px; height: 35px; vertical-align: middle;"/>
                         </a>
                         <a href="https://www.facebook.com/HotCopperAU">
                           <img src="{{ url('/img/social-media-logo/facebook.png') }}"  style="width: 33px; height: 33px; vertical-align: middle;"/>
                         </a>
                         <a href="https://www.linkedin.com/company/2445452">
                           <img src="{{ url('/img/social-media-logo/linked-in.png') }}"  style="width: 38px; height: 36px; vertical-align: middle;"/>
                         </a>
                         <a href="https://plus.google.com/u/0/+hotcopper">
                           <img src="{{ url('/img/social-media-logo/google-plus.png') }}"  style="width: 38px; height: 36px; vertical-align: middle;"/>
                         </a>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <!-- END FOOTER -->

          <!-- END CENTERED WHITE CONTAINER -->
          </div>
        </td>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
      </tr>
    </table>
  </body>
</html>
