<?php
//Riabilitare queste due righe per vedere errori se serve fare debugging
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

// session_start() va sempre all'inizio del codice PHP
session_start();

//Per connessione a DB e gestione login utenti
require_once('config.php');


//Per header pagina + SEO dinamico titolo e descrizione pagina in header
$description = "Mindflix homepages, all the movies and TV series you can think about. Just a personal, non-commercial project to learn web dev";
$title = "Homepage | Mindflix";
include("php/settings-pages-header.php");
?>

<div class="container"></div>
<div class="d-flex align-items-start">
  <div class="nav flex-column nav-pills me-3 w-0" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <!-- Per tutti questi tag <button> è possibile aggiunger el'attributo disabled qualora volessimo disattivarli e impedire all'utente
      di cliccare su quella voce di menù e accedere alle relative impostazioni -->
    <button class="nav-link interactive-tab active d-flex justify-content-between align-items-center" id="v-pills-apps-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-app-settings" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">App Settings <i class="bi bi-chevron-right"></i></button>
    <button class="nav-link interactive-tab d-flex justify-content-between align-items-center" id="v-pills-account-tab" data-bs-toggle="pill" data-bs-target="#v-pills-account" type="button" role="tab" aria-controls="v-pills-disabled" aria-selected="false">Account<i class="bi bi-chevron-right"></i></button>
    <button class="nav-link interactive-tab d-flex justify-content-between align-items-center" id="v-pills-help-tab" data-bs-toggle="pill" data-bs-target="#v-pills-help" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Membership <i class="bi bi-chevron-right"></i></button>
    <button class="nav-link interactive-tab d-flex justify-content-between align-items-center" id="v-pills-security-tab" data-bs-toggle="pill" data-bs-target="#v-pills-security" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Security <i class="bi bi-chevron-right"></i></button>
    <button class="nav-link interactive-tab d-flex justify-content-between align-items-center" id="v-pills-signout-tab" data-bs-toggle="pill" data-bs-target="#v-pills-signout" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Sign Out</button>
  </div>

  <!-- TODO: rinomina id e for in base a voce menu a colonna attivata -->
  <div class="tab-content px-4" id="v-pills-tabContent">
    <!-- TAB PANEL APP SETTINGS -->
    <div class="tab-pane fade show active" id="v-pills-app-settings" role="tabpanel" aria-labelledby="v-pills-appsettings-tab" tabindex="0">
      <a class="back-icon-container" href="#">
        <i class="bi bi-arrow-left-circle"></i>
      </a>
      <div class="sub-setting-box">
        <h3>Video Playback</h3>
        <h4>Cellular Data Usage</h4>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
          <label class="form-check-label" for="switchCheckDefault">Wifi Only</label>
        </div>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
          <label class="form-check-label" for="switchCheckDefault">Set automatically (this may allow mobile data usage to play videos)</label>
        </div>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
          <label class="form-check-label" for="switchCheckDefault">Alway play video at the best quality available</label>
        </div>
      </div>
      <div class="sub-setting-box">
        <h3>Notifications</h3>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
          <label class="form-check-label" for="switchCheckDefault">Allow notifications</label>
        </div>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
          <label class="form-check-label" for="switchCheckDefault">
            Push notifications about newly-added movies, TV shows, personalized suggestions
          </label>
        </div>
      </div>
      <div class="sub-setting-box">
        <h3>Appearance</h3>
        <h4>Theme</h4>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
          <label class="form-check-label" for="switchCheckDefault">Enable automatic switch to dark mode after 6pm</label>
        </div>
        <div class="quick-dropdown-option d-flex justify-content-between">
          <label>Choose a theme</label>
          <div class="button-container">
            <button class="btn btn-secondary btn-sm " type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Change
            </button>
            <ul class="dropdown-menu">
              <li id="dark-theme-option"><a class="dropdown-item" href="#">Dark</a></li>
              <li id="light-theme-option"><a class="dropdown-item" href="#">Light</a></li>
              <li id="ambiance-theme-option"><a class="dropdown-item" href="#">Ambiance</a></li>
            </ul>
          </div>
        </div>
        <div class="quick-dropdown-option d-flex justify-content-between">
          <label>Fontsize</label>
          <div class="button-container">
            <button class="btn btn-secondary btn-sm " type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Change
            </button>
            <ul class="dropdown-menu">
              <li id="font-sm-option"><a class="dropdown-item" href="#">Small</a></li>
              <li id="font-md-option"><a class="dropdown-item" href="#">Medium</a></li>
              <li id="font-lg-option"><a class="dropdown-item" href="#">Large</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>


    <!-- TAB PANEL ACCOUNT -->
    <div class="tab-pane fade" id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab" tabindex="0">
      <a class="back-icon-container" href="#"></a>
      <i class="bi bi-arrow-left-circle"></i>
      <div class="container text-center">
        <!-- Row 1 per immagine profile in settings -->
        <div class="row ">
          <div id="account-settings-view" class="col justify-content-start align-start">
            <img src="img/mindflix-profile-thumbnail.png" class="rounded" alt="Account profile picture">
          </div>
        </div>
        <!-- Row 2 che contiene tutte le sotto sezioni per Account Settings -->
        <div class="row">
          <!-- Colonna 1 vuota per spazio: 1/12 e mostra solo a partire da modalità lg di Bootsrap -->
          <div class="col-1 d-none d-lg-block">
          </div>
          <!-- Colonna 2 per sotto sezioni vere e proprio: 12/12 in mobile, 11/12 in desktop lg -->
          <div class="col-12 col-lg-11 text-start py-3">
            <div class="sub-setting-box d-flex justify-content-between">
              <div class="left-side">
                <h3>Language</h3>
                <!-- TODO rendere contenuto h4 dinamico in base a lingua scelta: -->
                <h4>English</h4>
              </div>
              <div class="right-side d-flex align-items-center justify-content-end">
                <!-- MENU MODAL scrollabile a tutta pagina (edit in style.css) X SCELTA LINGUE -->
                <button type="button" class="btn btn-primary modal-button btn-modal-main" data-bs-toggle="modal" data-bs-target="#myModal">
                  Change
                </button>
                <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Choose your language</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                      </div>
                      <div class="modal-body">
                        Lista lingue
                        <ul class="modal-list">
                          <!-- IMPROVE valutare se usare altri tag (es.<form> con <input> se voglio rendere sto menù davvero funzionante) -->
                          <li class="modal-scrollable-option"><a href="#">Bahasa Indonesia</a></li>
                          <li class="modal-scrollable-option"><a href="#">Čeština (Ceco)</a></li>
                          <li class="modal-scrollable-option"><a href="#">Dansk (Danese)</a></li>
                          <li class="modal-scrollable-option"><a href="#">Deutsch (Tedesco)</a></li>
                          <li class="modal-scrollable-option"><a href="#">English (Inglese)</a></li>
                          <li class="modal-scrollable-option"><a href="#">Español (Spagnolo)</a></li>
                          <li class="modal-scrollable-option"><a href="#">Filipino</a></li>
                          <li class="modal-scrollable-option"><a href="#">Français (Francese)</a></li>
                          <li class="modal-scrollable-option"><a href="#">Hrvatski (Croato)</a></li>
                          <li class="modal-scrollable-option"><a href="#">Italiano</a></li>
                          <li class="modal-scrollable-option"><a href="#">Magyar (Ungherese)</a></li>
                          <li class="modal-scrollable-option"><a href="#">Melayu (Malese)</a></li>
                          <li class="modal-scrollable-option"><a href="#">Nederlands (Olandese)</a></li>
                          <li class="modal-scrollable-option"><a href="#">Norsk Bokmål (Norvegese)</a></li>
                          <li class="modal-scrollable-option"><a href="#">Polski (Polacco)</a></li>
                          <li class="modal-scrollable-option"><a href="#">Português (Portoghese)</a></li>
                          <li class="modal-scrollable-option"><a href="#">Română (Rumeno)</a></li>
                          <li class="modal-scrollable-option"><a href="#">Suomi (Finlandese)</a></li>
                          <li class="modal-scrollable-option"><a href="#">Svenska (Svedese)</a></li>
                          <li class="modal-scrollable-option"><a href="#">Tiếng Việt (Vietnamita)</a></li>
                          <li class="modal-scrollable-option"><a href="#">Türkçe (Turco)</a></li>
                          <li class="modal-scrollable-option"><a href="#">Ελληνικά (Greco)</a></li>
                          <li class="modal-scrollable-option"><a href="#">Русский (Russo)</a></li>
                          <li class="modal-scrollable-option"><a href="#">Українська (Ucraino)</a></li>
                          <li class="modal-scrollable-option"><a href="#">עברית (Ebraico)</a></li>
                          <li class="modal-scrollable-option"><a href="#">العربية (Arabo)</a></li>
                          <li class="modal-scrollable-option"><a href="#">हिन्दी (Hindi)</a></li>
                          <li class="modal-scrollable-option"><a href="#">தமிழ் (Tamil)</a></li>
                          <li class="modal-scrollable-option"><a href="#">తెలుగు (Telugu)</a></li>
                          <li class="modal-scrollable-option"><a href="#">ไทย (Thai)</a></li>
                          <li class="modal-scrollable-option"><a href="#">中文 (Cinese)</a></li>
                          <li class="modal-scrollable-option"><a href="#">日本語 (Giapponese)</a></li>
                          <li class="modal-scrollable-option"><a href="#">한국어 (Coreano)</a></li>
                        </ul>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn modal-button btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                        <button type="button" class="btn modal-button btn-primary">Salva</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="sub-setting-box">
              <h3>Content filters</h3>
              <h4>Age-realted filters</h4>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
                <label class="form-check-label" for="switchCheckDefault">Allow 18+ contents</label>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
                <label class="form-check-label" for="switchCheckDefault">Turn this profile into a Kids profile (only suitable contents will be shown)</label>
              </div>
              <h4>Localized content</h4>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
                <label class="form-check-label" for="switchCheckDefault">
                  Only content related in your language and related to your location will be shown
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- TAB PANEL MEMBERSHIP -->
    <div class="tab-pane fade" id="v-pills-help" role="tabpanel" aria-labelledby="v-pills-help-tab" tabindex="0">
      <a class="back-icon-container" href="#">
        <i class="bi bi-arrow-left-circle"></i>
      </a>
      <div class="sub-setting-box d-flex justify-content-between">
        <div class="left-side">
          <h3>Your Plan</h3>
          <!-- TODO rendere contenuto h4 dinamico in base a lingua scelta: -->
          <h4>Standard Plan 1080p</h4>
        </div>
        <div class="right-side d-flex align-items-center justify-content-end">
          <!-- MENU MODAL scrollabile a tutta pagina (edit in style.css) X SCELTA PIANI MINDFLIX -->
          <button type="button" class="btn btn-primary modal-button btn-modal-main" data-bs-toggle="modal" data-bs-target="#myModalPlan">
            Change Plan
          </button>
          <div class="modal fade" id="myModalPlan" tabindex="-1" aria-labelledby="myModalPlanLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="myModalPlanLabel">Choose your new plan</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                </div>
                <div class="modal-body">
                  You can always switch back if you don't love it.
                  <ul class="modal-list">
                    <!-- IMPROVE valutare se usare altri tag (es.<form> con <input> se voglio rendere sto menù davvero funzionante) -->
                    <li class="modal-scrollable-option"><a href="#">Standard with ads - 1080p</a></li>
                    <li class="modal-scrollable-option"><a href="#">Standard - 1080p</a></li>
                    <li class="modal-scrollable-option"><a href="#">Premium - 4K + HDR</a></li>
                  </ul>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn modal-button btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                  <button type="button" class="btn modal-button btn-primary">Salva</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="sub-setting-box d-flex justify-content-between">
        <div class="left-side">
          <h3>Payments</h3>
          <!-- TODO rendere contenuto h4 dinamico in base a metodo pagamento scelto: -->
          <h4>Current method: Mastercard ****2685</h4>
        </div>
        <div class="right-side d-flex align-items-center justify-content-end">
          <!-- MENU MODAL scrollabile a tutta pagina (edit in style.css) X SCELTA MODALITA PAGAMENTO -->
          <button type="button" class="btn btn-primary modal-button btn-modal-main text-end" data-bs-toggle="modal" data-bs-target="#myModalPayment">
            Change Payment Method
          </button>
          <div class="modal fade" id="myModalPayment" tabindex="-1" aria-labelledby="myModalPaymentLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="myModalPaymentLabel">Manage your payment method</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                </div>
                <div class="modal-body">
                  Control how you pay for your membership.
                  <div class="current-pay-metod active d-flex justify-content-between">
                    <p class="m-0"> Mastercard ****2682</p>
                    <a href="#">Update</a>
                  </div>
                  <button type="button" class="btn btn-primary add-payment-btn modal-button btn-modal-main" data-bs-toggle="modal" data-bs-target="#myModalPayment">
                    <i class="bi bi-plus-lg"></i> Add Payment Method
                  </button>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn modal-button btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                  <button type="button" class="btn modal-button btn-primary">Salva</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="sub-setting-box">
        <h3>Next payment</h3>
        <h4>June 23, 2026</h4>
        <h4> **** **** **** 2685 </h4>
      </div>
    </div>


    <!-- TAB PANEL SECURITY -->
    <div class="tab-pane fade" id="v-pills-security" role="tabpanel" aria-labelledby="v-pills-signout-tab" tabindex="0">
      <a class="back-icon-container" href="#">
        <i class="bi bi-arrow-left-circle"></i>
      </a>
      <div class="sub-setting-box d-flex justify-content-between">
        <div class="left-side">
          <h4>Email</h4>
          <!-- TODO rendere contenuto h4 dinamico in base a metodo pagamento scelto: -->
          <h4>currentemail@gmail.com</h4>
        </div>
        <div class="right-side d-flex align-items-center justify-content-end">
          <!-- MENU MODAL scrollabile a tutta pagina (edit in style.css) X SCELTA MODALITA PAGAMENTO -->
          <button type="button" class="btn btn-primary modal-button btn-modal-main text-end" data-bs-toggle="modal" data-bs-target="#myModalChengeEmail">
            Change email
          </button>
          <div class="modal fade" id="myModalChengeEmail" tabindex="-1" aria-labelledby="myModalChengeEmail" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="myModalChengeEmail">Choose a new email address</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
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
                  <button type="button" class="btn modal-button btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                  <button type="button" class="btn modal-button btn-primary">Salva</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="sub-setting-box d-flex justify-content-between">
        <div class="left-side">
          <h4>Password</h4>
          <!-- TODO rendere contenuto h4 dinamico in base a metodo pagamento scelto: -->
          <h4>******</h4>
        </div>
        <div class="right-side d-flex align-items-center justify-content-end">
          <!-- MENU MODAL scrollabile a tutta pagina (edit in style.css) X SCELTA MODALITA PAGAMENTO -->
          <button type="button" class="btn btn-primary modal-button btn-modal-main text-end" data-bs-toggle="modal" data-bs-target="#myModalChengePassword">
            Change password
          </button>
          <div class="modal fade" id="myModalChengePassword" tabindex="-1" aria-labelledby="myModalChengePassword" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="myModalChengePassword">Create your new password</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
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
                  <button type="button" class="btn modal-button btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                  <button type="button" class="btn modal-button btn-primary">Salva</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="sub-setting-box d-flex justify-content-between">
        <div class="left-side">
          <h4>Mobile Phone</h4>
          <!-- TODO rendere contenuto h4 dinamico in base a metodo pagamento scelto: -->
          <h4>+00 000 0000000</h4>
        </div>
        <div class="right-side d-flex align-items-center justify-content-end">
          <!-- MENU MODAL scrollabile a tutta pagina (edit in style.css) X SCELTA MODALITA PAGAMENTO -->
          <button type="button" class="btn btn-primary modal-button btn-modal-main text-end" data-bs-toggle="modal" data-bs-target="#myModalChengePhone">
            Change mobile phone
          </button>
          <div class="modal fade" id="myModalChengePhone" tabindex="-1" aria-labelledby="myModalChengePhone" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="myModalChengePhone">Manage your mobile phone number</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
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
                  <button type="button" class="btn modal-button btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                  <button type="button" class="btn modal-button btn-primary">Salva</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

















<!-- Footer -->
<?php
require('php/main-pages-footer.php');
?>


</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
  crossorigin="anonymous"></script>
<script src="js/script.js"></script>

</html>