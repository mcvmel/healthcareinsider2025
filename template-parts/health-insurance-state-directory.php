<?php
// Get ACF fields
$text    = get_sub_field('text');

?>

<section class="state-directory-text">
    <div class="container">
        <?php if ($text): ?>
            <div class="hero-block__inner__right__form">
                <?php echo $text; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="state-legend">
    <div class="container">
        <ul class="state-legend__list">
            <li class="state-legend__list__item state-legend__list__item--a-g" data-state="a-g">A–G</li>
            <li class="state-legend__list__item state-legend__list__item--h-m" data-state="h-m">H–M</li>
            <li class="state-legend__list__item state-legend__list__item--n-s" data-state="n-s">N–S</li>
            <li class="state-legend__list__item state-legend__list__item--t-w" data-state="t-w">T–W</li>
        </ul>
    </div>
</section>


<section class="state-links">
    <div class="container">
        <ul class="state-links__links state-links__links--a-g" data-state="a-g">
            <!-- All states starting with A–G -->
            <li><a href="#">alabama</a></li>
            <li><a href="#">alaska</a></li>
            <li><a href="#">arizona</a></li>
            <li><a href="#">arkansas</a></li>
            <li><a href="#">california</a></li>
            <li><a href="#">colorado</a></li>
            <li><a href="#">connecticut</a></li>
            <li><a href="#">delaware</a></li>
            <li><a href="#">district of columbia</a></li>
            <li><a href="#">florida</a></li>
            <li><a href="#">georgia</a></li>
        </ul>

        <ul class="state-links__links state-links__links--h-m" data-state="h-m">
            <!-- All states starting with H–M -->
            <li><a href="#">hawaii</a></li>
            <li><a href="#">idaho</a></li>
            <li><a href="#">illinois</a></li>
            <li><a href="#">indiana</a></li>
            <li><a href="#">iowa</a></li>
            <li><a href="#">kansas</a></li>
            <li><a href="#">kentucky</a></li>
            <li><a href="#">louisiana</a></li>
            <li><a href="#">maine</a></li>
            <li><a href="#">maryland</a></li>
            <li><a href="#">massachusetts</a></li>
            <li><a href="#">michigan</a></li>
            <li><a href="#">minnesota</a></li>
            <li><a href="#">mississippi</a></li>
            <li><a href="#">missouri</a></li>
            <li><a href="#">montana</a></li>
        </ul>

        <ul class="state-links__links state-links__links--n-s" data-state="n-s">
            <!-- All states starting with N–S -->
            <li><a href="#">nevada</a></li>
            <li><a href="#">new hampshire</a></li>
            <li><a href="#">new jersey</a></li>
            <li><a href="#">new mexico</a></li>
            <li><a href="#">new york</a></li>
            <li><a href="#">north carolina</a></li>
            <li><a href="#">north dakota</a></li>
            <li><a href="#">ohio</a></li>
            <li><a href="#">oklahoma</a></li>
            <li><a href="#">oregon</a></li>
            <li><a href="#">pennsylvania</a></li>
            <li><a href="#">rhode island</a></li>
            <li><a href="#">south carolina</a></li>
            <li><a href="#">south dakota</a></li>
        </ul>

        <ul class="state-links__links state-links__links--t-w" data-state="t-w">
            <!-- All states starting with T–W -->
            <li><a href="#">texas</a></li>
            <li><a href="#">utah</a></li>
            <li><a href="#">vermont</a></li>
            <li><a href="#">virginia</a></li>
            <li><a href="#">washington</a></li>
            <li><a href="#">west virginia</a></li>
            <li><a href="#">wisconsin</a></li>
            <li><a href="#">wyoming</a></li>
        </ul>
    </div>
</section>


