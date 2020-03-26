<style type="text/css">
  @font-face {
    font-family: "UCF-Sans-Serif-Alt";
    font-style: normal;
    font-weight: 400;
    src: url('https://s3.amazonaws.com/web.ucf.edu/email/common-assets/fonts/ucfsansserifalt-medium-webfont.woff2') format("woff2"),
	  url('https://s3.amazonaws.com/web.ucf.edu/email/common-assets/fonts/ucfsansserifalt-medium-webfont.woff') format("woff");
	mso-font-alt: 'Arial';
  }
  @font-face {
    font-family: "UCF-Sans-Serif-Alt";
    font-style: normal;
    font-weight: 500;
    src: url('https://s3.amazonaws.com/web.ucf.edu/email/common-assets/fonts/ucfsansserifalt-semibold-webfont.woff2') format("woff2"),
	  url('https://s3.amazonaws.com/web.ucf.edu/email/common-assets/fonts/ucfsansserifalt-semibold-webfont.woff') format("woff");
	mso-font-alt: 'Arial';
  }
  @font-face {
    font-family: "UCF-Sans-Serif-Alt";
    font-style: normal;
    font-weight: 700;
    src: url('https://s3.amazonaws.com/web.ucf.edu/email/common-assets/fonts/ucfsansserifalt-bold-webfont.woff2') format("woff2"),
	  url('https://s3.amazonaws.com/web.ucf.edu/email/common-assets/fonts/ucfsansserifalt-bold-webfont.woff') format("woff");
	mso-font-alt: 'Arial';
  }


  /* CSS Resets */

  .ReadMsgBody {
    width: 100%;
    background-color: #ffffff;
  }

  .ExternalClass {
    width: 100%;
    background-color: #ffffff;
  }

  .ExternalClass,
  .ExternalClass p,
  .ExternalClass span,
  .ExternalClass font,
  .ExternalClass td,
  .ExternalClass div {
    line-height: 100%;
  }

  * {
    zoom: 1;
  }

  body {
    -webkit-text-size-adjust: none; /* ios likes to enforce a minimum font size of 13px; kill it with this */
    -ms-text-size-adjust: none;
	margin: 0;
    padding: 0;
  }

  table {
    border-spacing: 0;
  }

  table td {
    border-collapse: collapse;
  }

  a {
    color: #006699;
  }


  @media all and (max-width: 640px) {

    /* The outermost wrapper table */
    table.t640 {
      width: 100% !important;
      border-left: 0px solid transparent !important;
      border-right: 0px solid transparent !important;
      margin: 0 !important;
    }

    /* The firstmost inner tables, which should be padded at mobile sizes */
    table.t564 {
      width: 100% !important;
      padding-left: 15px;
      padding-right: 15px;
      padding-top: 15px !important;
      border-left: 0px solid transparent !important;
      border-right: 0px solid transparent !important;
      margin: 0 !important;
    }

    /* Generic class for a table column that should collapse to 100% width at mobile sizes (with bottom padding) */
    td.ccollapse100pb {
      display: block !important;
      overflow: hidden;
      width: 100% !important;
      float: left;
      clear: both;
      margin-left: 0 !important;
      margin-right: 0 !important;
      padding-left: 0 !important;
      padding-right: 0 !important;
      padding-bottom: 20px !important;
      border-left: 0px solid transparent !important;
      border-right: 0px solid transparent !important;
    }

    /* Generic class for a table column that should collapse to 100% width at mobile sizes (with top padding) */
    td.ccollapse100pt {
      display: block !important;
      overflow: hidden;
      width: 100% !important;
      float: left;
      clear: both;
      margin-left: 0 !important;
      margin-right: 0 !important;
      padding-left: 0 !important;
      padding-right: 0 !important;
      padding-top: 20px !important;
      border-left: 0px solid transparent !important;
      border-right: 0px solid transparent !important;
    }

    /* Generic class for a table column that should collapse to 50% width at mobile sizes (with bottom padding) */
    td.ccollapse50pb {
      display: block !important;
      overflow: hidden;
      width: 50% !important;
      float: left;
      clear: both;
      margin-left: 0 !important;
      margin-right: 0 !important;
      padding-left: 0 !important;
      padding-right: 0 !important;
      padding-bottom: 20px !important;
      border-left: 0px solid transparent !important;
      border-right: 0px solid transparent !important;
    }

    /* Generic class for a table column that should collapse to 100% width at mobile sizes */
    td.ccollapse100 {
      display: block !important;
      overflow: hidden;
      clear: both;
      width: 100% !important;
      float: left !important;
      margin-left: 0 !important;
      margin-right: 0 !important;
      padding-left: 0 !important;
      padding-right: 0 !important;
      border-left: 0px solid transparent !important;
      border-right: 0px solid transparent !important;
    }

    /* Generic class for a table within a column that should be forced to 100% width at mobile sizes */
    table.tcollapse100 {
      width: 100% !important;
      margin-left: 0 !important;
      margin-right: 0 !important;
      padding-left: 0 !important;
      padding-right: 0 !important;
      border-left: 0px solid transparent !important;
      border-right: 0px solid transparent !important;
    }

    /* Forces an image to fit 100% width of its parent */
    img.responsiveimg {
      max-width: none !important;
      width: 100% !important;
    }

    img.responsiveimgmw {
      max-width: 100% !important;
    }

    /* remove padding since 100% width */
    img.responsiveimgpb {
      width: 100% !important;
      margin-left: 0 !important;
      margin-right: 0 !important;
      padding-left: 0 !important;
      padding-right: 0 !important;
      padding-bottom: 20px !important;
    }
  }

  <?php if ( is_admin_bar_showing() ) : ?>
    body {
      margin-top: 46px;
    }

    @media (min-width: 783px) {
      body {
        margin-top: 30px;
      }
    }
  <?php endif; ?>
</style>
