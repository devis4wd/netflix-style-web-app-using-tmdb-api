<?php
// Enable these only during local debugging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/*
  account-settings.php

  Purpose:
  - Protected page (requires authentication)
  - Settings UI is mostly static (demo), with mobile UX handled in script.js
  - This page currently does not persist settings to DB (UI-only prototype)
*/

session_start();

/*
  Access control:
  If the user is not logged in, redirect to login.php.
*/
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header('Location: login.php');
  exit();
}

// DB connection is required here mainly because the header/navbar may show user state.
require_once('config.php');

// Page SEO metadata
$description = "Mindflix account settings. Personal, non-commercial project to learn web development.";
$title = "Account Settings | Mindflix";
include("php/settings-pages-header.php");
?>

<main class="container-fluid">
  <div class="d-flex align-items-start">

    <!-- Left vertical navigation -->
    <nav class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical" aria-label="Settings navigation">
      <!-- Buttons can be disabled if you want to lock specific sections -->
      <button
        class="nav-link interactive-tab active d-flex justify-content-between align-items-center"
        id="v-pills-app-settings-tab"
        data-bs-toggle="pill"
        data-bs-target="#v-pills-app-settings"
        type="button"
        role="tab"
        aria-controls="v-pills-app-settings"
        aria-selected="true">
        App Settings <i class="bi bi-chevron-right" aria-hidden="true"></i>
      </button>

      <button
        class="nav-link interactive-tab d-flex justify-content-between align-items-center"
        id="v-pills-account-tab"
        data-bs-toggle="pill"
        data-bs-target="#v-pills-account"
        type="button"
        role="tab"
        aria-controls="v-pills-account"
        aria-selected="false">
        Account <i class="bi bi-chevron-right" aria-hidden="true"></i>
      </button>

      <button
        class="nav-link interactive-tab d-flex justify-content-between align-items-center"
        id="v-pills-membership-tab"
        data-bs-toggle="pill"
        data-bs-target="#v-pills-membership"
        type="button"
        role="tab"
        aria-controls="v-pills-membership"
        aria-selected="false">
        Membership <i class="bi bi-chevron-right" aria-hidden="true"></i>
      </button>

      <button
        class="nav-link interactive-tab d-flex justify-content-between align-items-center"
        id="v-pills-security-tab"
        data-bs-toggle="pill"
        data-bs-target="#v-pills-security"
        type="button"
        role="tab"
        aria-controls="v-pills-security"
        aria-selected="false">
        Security <i class="bi bi-chevron-right" aria-hidden="true"></i>
      </button>

      <button
        class="nav-link interactive-tab d-flex justify-content-between align-items-center"
        id="v-pills-signout-tab"
        data-bs-toggle="pill"
        data-bs-target="#v-pills-signout"
        type="button"
        role="tab"
        aria-controls="v-pills-signout"
        aria-selected="false">
        Sign Out
      </button>
    </nav>

    <!-- Right content panels -->
    <section class="tab-content px-4" id="v-pills-tabContent" aria-label="Settings content">

      <!-- TAB PANEL: APP SETTINGS -->
      <section
        class="tab-pane fade show active"
        id="v-pills-app-settings"
        role="tabpanel"
        aria-labelledby="v-pills-app-settings-tab"
        tabindex="0">

        <a class="back-icon-container" href="#" aria-label="Back to settings menu">
          <i class="bi bi-arrow-left-circle" aria-hidden="true"></i>
        </a>

        <section class="sub-setting-box" aria-label="Video playback">
          <h2 class="h3">Video Playback</h2>
          <h3 class="h4">Cellular Data Usage</h3>

          <!-- Note: IDs must be unique. Keeping your structure but assigning distinct IDs. -->
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="cellular-wifi-only">
            <label class="form-check-label" for="cellular-wifi-only">Wi-Fi only</label>
          </div>

          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="cellular-auto">
            <label class="form-check-label" for="cellular-auto">Set automatically (may use mobile data to play videos)</label>
          </div>

          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="play-best-quality">
            <label class="form-check-label" for="play-best-quality">Always play at the best available quality</label>
          </div>
        </section>

        <section class="sub-setting-box" aria-label="Notifications">
          <h2 class="h3">Notifications</h2>

          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="allow-notifications">
            <label class="form-check-label" for="allow-notifications">Allow notifications</label>
          </div>

          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="push-notifications">
            <label class="form-check-label" for="push-notifications">
              Push notifications about newly added movies, TV shows, and personalized suggestions
            </label>
          </div>
        </section>

        <section class="sub-setting-box" aria-label="Appearance">
          <h2 class="h3">Appearance</h2>
          <h3 class="h4">Theme</h3>

          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="auto-dark-after-6pm">
            <label class="form-check-label" for="auto-dark-after-6pm">Enable automatic dark mode after 6pm</label>
          </div>

          <div class="quick-dropdown-option d-flex justify-content-between">
            <label>Choose a theme</label>
            <div class="button-container">
              <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Change
              </button>
              <ul class="dropdown-menu" aria-label="Theme options">
                <li id="dark-theme-option"><a class="dropdown-item" href="#">Dark</a></li>
                <li id="light-theme-option"><a class="dropdown-item" href="#">Light</a></li>
                <li id="ambiance-theme-option"><a class="dropdown-item" href="#">Ambiance</a></li>
              </ul>
            </div>
          </div>

          <div class="quick-dropdown-option d-flex justify-content-between">
            <label>Font size</label>
            <div class="button-container">
              <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Change
              </button>
              <ul class="dropdown-menu" aria-label="Font size options">
                <li id="font-sm-option"><a class="dropdown-item" href="#">Small</a></li>
                <li id="font-md-option"><a class="dropdown-item" href="#">Medium</a></li>
                <li id="font-lg-option"><a class="dropdown-item" href="#">Large</a></li>
              </ul>
            </div>
          </div>
        </section>
      </section>

      <!-- TAB PANEL: ACCOUNT -->
      <section
        class="tab-pane fade"
        id="v-pills-account"
        role="tabpanel"
        aria-labelledby="v-pills-account-tab"
        tabindex="0">

        <a class="back-icon-container" href="#" aria-label="Back to settings menu">
          <i class="bi bi-arrow-left-circle" aria-hidden="true"></i>
        </a>

        <section class="container text-center" aria-label="Account settings">
          <div class="row">
            <div id="account-settings-view" class="col justify-content-start align-start">
              <img src="img/mindflix-profile-thumbnail.png" class="rounded" alt="Account profile picture">
            </div>
          </div>

          <div class="row">
            <div class="col-1 d-none d-lg-block"></div>

            <div class="col-12 col-lg-11 text-start py-3">
              <div class="sub-setting-box d-flex justify-content-between">
                <div class="left-side">
                  <h2 class="h3">Language</h2>
                  <h3 class="h4">English</h3>
                </div>

                <div class="right-side d-flex align-items-center justify-content-end">
                  <button type="button" class="btn btn-primary modal-button btn-modal-main"
                    data-bs-toggle="modal" data-bs-target="#languageModal">
                    Change
                  </button>

                  <div class="modal fade" id="languageModal" tabindex="-1" aria-labelledby="languageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="languageModalLabel">Choose your language</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                          <p class="mb-2">Language list (UI-only demo):</p>
                          <ul class="modal-list">
                            <li class="modal-scrollable-option"><a href="#">Bahasa Indonesia</a></li>
                            <li class="modal-scrollable-option"><a href="#">Čeština</a></li>
                            <li class="modal-scrollable-option"><a href="#">Dansk</a></li>
                            <li class="modal-scrollable-option"><a href="#">Deutsch</a></li>
                            <li class="modal-scrollable-option"><a href="#">English</a></li>
                            <li class="modal-scrollable-option"><a href="#">Español</a></li>
                            <li class="modal-scrollable-option"><a href="#">Filipino</a></li>
                            <li class="modal-scrollable-option"><a href="#">Français</a></li>
                            <li class="modal-scrollable-option"><a href="#">Hrvatski</a></li>
                            <li class="modal-scrollable-option"><a href="#">Italiano</a></li>
                            <li class="modal-scrollable-option"><a href="#">Magyar</a></li>
                            <li class="modal-scrollable-option"><a href="#">Melayu</a></li>
                            <li class="modal-scrollable-option"><a href="#">Nederlands</a></li>
                            <li class="modal-scrollable-option"><a href="#">Norsk Bokmål</a></li>
                            <li class="modal-scrollable-option"><a href="#">Polski</a></li>
                            <li class="modal-scrollable-option"><a href="#">Português</a></li>
                            <li class="modal-scrollable-option"><a href="#">Română</a></li>
                            <li class="modal-scrollable-option"><a href="#">Suomi</a></li>
                            <li class="modal-scrollable-option"><a href="#">Svenska</a></li>
                            <li class="modal-scrollable-option"><a href="#">Tiếng Việt</a></li>
                            <li class="modal-scrollable-option"><a href="#">Türkçe</a></li>
                            <li class="modal-scrollable-option"><a href="#">Ελληνικά</a></li>
                            <li class="modal-scrollable-option"><a href="#">Русский</a></li>
                            <li class="modal-scrollable-option"><a href="#">Українська</a></li>
                            <li class="modal-scrollable-option"><a href="#">עברית</a></li>
                            <li class="modal-scrollable-option"><a href="#">العربية</a></li>
                            <li class="modal-scrollable-option"><a href="#">हिन्दी</a></li>
                            <li class="modal-scrollable-option"><a href="#">தமிழ்</a></li>
                            <li class="modal-scrollable-option"><a href="#">తెలుగు</a></li>
                            <li class="modal-scrollable-option"><a href="#">ไทย</a></li>
                            <li class="modal-scrollable-option"><a href="#">中文</a></li>
                            <li class="modal-scrollable-option"><a href="#">日本語</a></li>
                            <li class="modal-scrollable-option"><a href="#">한국어</a></li>
                          </ul>
                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn modal-button btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="button" class="btn modal-button btn-primary">Save</button>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <div class="sub-setting-box">
                <h2 class="h3">Content filters</h2>
                <h3 class="h4">Age-related filters</h3>

                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" role="switch" id="allow-18plus">
                  <label class="form-check-label" for="allow-18plus">Allow 18+ content</label>
                </div>

                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" role="switch" id="kids-profile">
                  <label class="form-check-label" for="kids-profile">Turn this profile into a Kids profile (only suitable content will be shown)</label>
                </div>

                <h3 class="h4">Localized content</h3>

                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" role="switch" id="localized-content-only">
                  <label class="form-check-label" for="localized-content-only">
                    Show content in my language and relevant to my location
                  </label>
                </div>
              </div>

            </div>
          </div>
        </section>
      </section>

      <!-- TAB PANEL: MEMBERSHIP -->
      <section
        class="tab-pane fade"
        id="v-pills-membership"
        role="tabpanel"
        aria-labelledby="v-pills-membership-tab"
        tabindex="0">

        <a class="back-icon-container" href="#" aria-label="Back to settings menu">
          <i class="bi bi-arrow-left-circle" aria-hidden="true"></i>
        </a>

        <div class="sub-setting-box d-flex justify-content-between">
          <div class="left-side">
            <h2 class="h3">Your Plan</h2>
            <h3 class="h4">Standard Plan 1080p</h3>
          </div>

          <div class="right-side d-flex align-items-center justify-content-end">
            <button type="button" class="btn btn-primary modal-button btn-modal-main"
              data-bs-toggle="modal" data-bs-target="#planModal">
              Change Plan
            </button>

            <div class="modal fade" id="planModal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="planModalLabel">Choose your new plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                    <p class="mb-2">You can always switch back if you change your mind.</p>
                    <ul class="modal-list">
                      <li class="modal-scrollable-option"><a href="#">Standard with ads - 1080p</a></li>
                      <li class="modal-scrollable-option"><a href="#">Standard - 1080p</a></li>
                      <li class="modal-scrollable-option"><a href="#">Premium - 4K + HDR</a></li>
                    </ul>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn modal-button btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn modal-button btn-primary">Save</button>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="sub-setting-box d-flex justify-content-between">
          <div class="left-side">
            <h2 class="h3">Payments</h2>
            <h3 class="h4">Current method: Mastercard ****2685</h3>
          </div>

          <div class="right-side d-flex align-items-center justify-content-end">
            <button type="button" class="btn btn-primary modal-button btn-modal-main text-end"
              data-bs-toggle="modal" data-bs-target="#paymentModal">
              Change Payment Method
            </button>

            <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Manage your payment method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                    <p class="mb-2">Control how you pay for your membership.</p>
                    <div class="current-pay-metod active d-flex justify-content-between">
                      <p class="m-0">Mastercard ****2682</p>
                      <a href="#">Update</a>
                    </div>

                    <button type="button" class="btn btn-primary add-payment-btn modal-button btn-modal-main">
                      <i class="bi bi-plus-lg" aria-hidden="true"></i> Add Payment Method
                    </button>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn modal-button btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn modal-button btn-primary">Save</button>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="sub-setting-box">
          <h2 class="h3">Next payment</h2>
          <h3 class="h4">June 23, 2026</h3>
          <h3 class="h4">**** **** **** 2685</h3>
        </div>
      </section>

      <!-- TAB PANEL: SECURITY -->
      <section
        class="tab-pane fade"
        id="v-pills-security"
        role="tabpanel"
        aria-labelledby="v-pills-security-tab"
        tabindex="0">

        <a class="back-icon-container" href="#" aria-label="Back to settings menu">
          <i class="bi bi-arrow-left-circle" aria-hidden="true"></i>
        </a>

        <div class="sub-setting-box d-flex justify-content-between">
          <div class="left-side">
            <h2 class="h4">Email</h2>
            <p class="m-0 text-muted">currentemail@gmail.com</p>
          </div>

          <div class="right-side d-flex align-items-center justify-content-end">
            <button type="button" class="btn btn-primary modal-button btn-modal-main text-end"
              data-bs-toggle="modal" data-bs-target="#emailModal">
              Change email
            </button>

            <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="emailModalLabel">Choose a new email address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                    <form id="change-usrmail-form">
                      <div class="mb-3">
                        <label for="old-email" class="col-form-label">Type current email:</label>
                        <input type="email" class="form-control" id="old-email">
                      </div>
                      <div class="mb-3">
                        <label for="new-email" class="col-form-label">Type new email:</label>
                        <input type="email" class="form-control" id="new-email">
                      </div>
                      <div class="mb-3">
                        <label for="new-email-confirm" class="col-form-label">Confirm new email:</label>
                        <input type="email" class="form-control" id="new-email-confirm">
                      </div>
                    </form>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn modal-button btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn modal-button btn-primary">Save</button>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="sub-setting-box d-flex justify-content-between">
          <div class="left-side">
            <h2 class="h4">Password</h2>
            <p class="m-0 text-muted">******</p>
          </div>

          <div class="right-side d-flex align-items-center justify-content-end">
            <button type="button" class="btn btn-primary modal-button btn-modal-main text-end"
              data-bs-toggle="modal" data-bs-target="#passwordModal">
              Change password
            </button>

            <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Create your new password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                    <form id="change-usrpwd-form">
                      <div class="mb-3">
                        <label for="old-password" class="col-form-label">Type current password:</label>
                        <input type="password" class="form-control" id="old-password">
                      </div>
                      <div class="mb-3">
                        <label for="new-password" class="col-form-label">Type new password:</label>
                        <input type="password" class="form-control" id="new-password">
                      </div>
                      <div class="mb-3">
                        <label for="new-password-confirm" class="col-form-label">Confirm new password:</label>
                        <input type="password" class="form-control" id="new-password-confirm">
                      </div>
                    </form>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn modal-button btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn modal-button btn-primary">Save</button>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="sub-setting-box d-flex justify-content-between">
          <div class="left-side">
            <h2 class="h4">Mobile Phone</h2>
            <p class="m-0 text-muted">+00 000 0000000</p>
          </div>

          <div class="right-side d-flex align-items-center justify-content-end">
            <button type="button" class="btn btn-primary modal-button btn-modal-main text-end"
              data-bs-toggle="modal" data-bs-target="#phoneModal">
              Change mobile phone
            </button>

            <div class="modal fade" id="phoneModal" tabindex="-1" aria-labelledby="phoneModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="phoneModalLabel">Manage your mobile phone number</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                    <form id="change-usrphone-form">
                      <div class="mb-3">
                        <label for="old-phone" class="col-form-label">Type current phone:</label>
                        <input type="text" class="form-control" id="old-phone">
                      </div>
                      <div class="mb-3">
                        <label for="new-phone" class="col-form-label">Type new phone:</label>
                        <input type="text" class="form-control" id="new-phone">
                      </div>
                      <div class="mb-3">
                        <label for="new-phone-confirm" class="col-form-label">Confirm new phone:</label>
                        <input type="text" class="form-control" id="new-phone-confirm">
                      </div>
                    </form>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn modal-button btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn modal-button btn-primary">Save</button>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </section>

      <!-- TAB PANEL: SIGN OUT (placeholder) -->
      <section
        class="tab-pane fade"
        id="v-pills-signout"
        role="tabpanel"
        aria-labelledby="v-pills-signout-tab"
        tabindex="0">

        <a class="back-icon-container" href="#" aria-label="Back to settings menu">
          <i class="bi bi-arrow-left-circle" aria-hidden="true"></i>
        </a>

        <div class="sub-setting-box">
          <h2 class="h3">Sign Out</h2>
          <p class="m-0">This section is a UI placeholder. Use the dedicated logout route to end the session.</p>
        </div>
      </section>

    </section>
  </div>
</main>

<?php require('php/main-pages-footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
  crossorigin="anonymous"></script>
<script src="js/script.js"></script>
</body>

</html>