
 <div style="width: 210mm;">
    <div class="row" style="margin-left: 1px;">
        <div class="col-xs-3">
            <img src="{php}$info=get_company_details_info(); echo $info['image'];{/php}" alt="Kticket" style="width: 200px; height: 200px;"/>
        </div>
        <div class="col-xs-9" >
            <div style="font-size: 13px; margin-top: -10px;margin-left: 10px;">
                 <h1><strong>{php}$info=get_company_details_info(); echo $info['name'];{/php}</strong></h1>
                {php}$info=get_company_details_info(); echo $info['address'];{/php}<br />
                <strong>Hot Line : </strong>{php}$info=get_company_details_info(); echo $info['tel'];{/php} <strong>Fax : </strong>{php}$info=get_company_details_info(); echo $info['fax'];{/php} <br />
                <strong>E-mail : </strong>{php}$info=get_company_details_info(); echo $info['email'];{/php}  <br />
                <strong>Web : </strong>{php}$info=get_company_details_info(); echo $info['website'];{/php}  <br />
                <strong>Branches : </strong>{php}$info=get_company_details_info(); echo $info['branches'];{/php}
            </div>
        </div>
    </div>