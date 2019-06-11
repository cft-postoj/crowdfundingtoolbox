<div class="cft--myAccount">
    <div class="cft--myAccount--sidebar">
        <ul>
            <li class="active">
                <a href="#">
                    Prehľad
                </a>
            </li>
            <li>
                <a href="#newsletter">
                    Newsletter
                </a>
            </li>
            <li>
                <a href="#ulozene-clanky">
                    Uložené články
                </a>
            </li>
            <li>
                <a href="#vasa-podpora">
                    Vaša podpora
                </a>
            </li>
            <li>
                <a href="#objednavky">
                    Objednávky
                </a>
            </li>
            <li>
                <a href="#ucet">
                    Účet
                </a>
            </li>
        </ul>
    </div>
    <div class="cft--myAccount--body">
        <div id="cft-myAccount--preview">
            @include('portal-templates.myAccount.parts.preview')
        </div>
        <div id="cft-myAccount--newsletter" style="display: none;">
            @include('portal-templates.myAccount.parts.newsletter')
        </div>
        <div id="cft-myAccount--savedArticles" style="display: none;">
            @include('portal-templates.myAccount.parts.savedArticles')
        </div>
        <div id="cft-myAccount--donations" style="display: none;">
            @include('portal-templates.myAccount.parts.donations')
        </div>
        <div id="cft-myAccount--orders" style="display: none;">
            @include('portal-templates.myAccount.parts.orders')
        </div>
        <div id="cft-myAccount--account" style="display: none;">
            @include('portal-templates.myAccount.parts.account')
        </div>
    </div>
</div>