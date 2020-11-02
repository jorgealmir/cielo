<?php

namespace Src;

/**
 * Description of ErrorCielo
 *
 * @author Jorge
 */
class Error
{
    public function getError($code): string 
    {
        if ($code == '0') {
            return "Internal error";
        } elseif ($code == '100') {    
            return "RequestId is required";
        } elseif ($code == '101') {    
            return "MerchantId is required";
        } elseif ($code == '102') {	 
            return "Payment Type is required";
        } elseif ($code == '103') {	 
            return "Payment Type can only contain letters";
        } elseif ($code == '104') {	 
            return "Customer Identity is required";
        } elseif ($code == '105') {	 
            return "Customer Name is required";
        } elseif ($code == '106') {	 
            return "Transaction ID is required";
        } elseif ($code == '107') {	 
            return "OrderId is invalid or does not exists";
        } elseif ($code == '108') {	 
            return "Valor da transação deve ser maior que “0”";
        } elseif ($code == '109') {	 
            return "Payment Currency is required";
        } elseif ($code == '110') {	 
            return "Invalid Payment Currency";
        } elseif ($code == '111') {	 
            return "Payment Country is required";
        } elseif ($code == '112') {	 
            return "Invalid Payment Country";
        } elseif ($code == '113') {	 
            return "Invalid Payment Code";
        } elseif ($code == '114') {	 
            return "The provided MerchantId is not in correct format";
        } elseif ($code == '115') {	 
            return "The provided MerchantId was not found";
        } elseif ($code == '116') {	 
            return "The provided MerchantId is blocked";
        } elseif ($code == '117') {	 
            return "Credit Card Holder is required";
        } elseif ($code == '118') {	 
            return "Credit Card Number is required";
        } elseif ($code == '119') {	 
            return "At least one Payment is required";
        } elseif ($code == '120') {	 
            return "Request IP not allowed. Check your IP White List";
        } elseif ($code == '121') {	 
            return "Customer is required";
        } elseif ($code == '122') {	 
            return "MerchantOrderId is required";
        } elseif ($code == '123') {	 
            return "Installments must be greater or equal to one";
        } elseif ($code == '124') {	 
            return "Credit Card is Required";
        } elseif ($code == '125') {	 
            return "Credit Card Expiration Date is required";
        } elseif ($code == '126') {
            return 'Data da expiração do cartão de crédito esta inválida';	
        } elseif ($code == '127') {	 
            return "You must provide CreditCard Number";	
        } elseif ($code == '128') {	 
            return "Card Number length exceeded";
        } elseif ($code == '129') {	 
            return "Affiliation not found";
        } elseif ($code == '130') {	 
            return "Could not get Credit Card";	
        } elseif ($code == '131') {
            return "MerchantKey is required";
        } elseif ($code == '132') {
            return "MerchantKey is invalid";
        } elseif ($code == '133') {
            return "Provider is not supported for this Payment Type";
        } elseif ($code == '134') {
            return "FingerPrint length exceeded";
        } elseif ($code == '135') {
            return "MerchantDefinedFieldValue length exceeded";
        } elseif ($code == '136') {
            return "ItemDataName length exceeded";
        } elseif ($code == '137') {
            return "ItemDataSKU length exceeded";
        } elseif ($code == '138') {
            return "PassengerDataName length exceeded";
        } elseif ($code == '139') {
            return "PassengerDataStatus length exceeded";
        } elseif ($code == '140') {
            return "PassengerDataEmail length exceeded";
        } elseif ($code == '141') {
            return "PassengerDataPhone length exceeded";
        } elseif ($code == '142') {
            return "TravelDataRoute length exceeded";
        } elseif ($code == '143') {
            return "TravelDataJourneyType length exceeded";
        } elseif ($code == '144') {
            return "TravelLegDataDestination length exceeded";
        } elseif ($code == '145') {
            return "TravelLegDataOrigin length exceeded";
        } elseif ($code == '146') {
            return "SecurityCode length exceeded";
        } elseif ($code == '147') {
            return "Address Street length exceeded";
        } elseif ($code == '148') {
            return "Address Number length exceeded";
        } elseif ($code == '149') {
            return "Address Complement length exceeded";
        } elseif ($code == '150') {
            return "Address ZipCode length exceeded";
        } elseif ($code == '151') {
            return "Address City length exceeded";
        } elseif ($code == '152') {
            return "Address State length exceeded";
        } elseif ($code == '153') {
            return "Address Country length exceeded";
        } elseif ($code == '154') {
            return "Address District length exceeded";
        } elseif ($code == '155') {
            return "Customer Name length exceeded";
        } elseif ($code == '156') {
            return "Customer Identity length exceeded";
        } elseif ($code == '157') {
            return "Customer IdentityType length exceeded";
        } elseif ($code == '158') {
            return "Customer Email length exceeded";
        } elseif ($code == '159') {
            return "ExtraData Name length exceeded";
        } elseif ($code == '160') {
            return "ExtraData Value length exceeded";
        } elseif ($code == '161') {
            return "Boleto Instructions length exceeded";
        } elseif ($code == '162') {
            return "Boleto Demostrative length exceeded";
        } elseif ($code == '163') {
            return "Return Url is required";
        } elseif ($code == '166') {
            return "AuthorizeNow is required";
        } elseif ($code == '167') {
            return "Antifraud not configured";
        } elseif ($code == '168') {
            return "Recurrent Payment not found";
        } elseif ($code == '169') {
            return "Recurrent Payment is not active";
        } elseif ($code == '170') {
            return "Cartão Protegido not configured";
        } elseif ($code == '171') {
            return "Affiliation data not sent";
        } elseif ($code == '172') {
            return "Credential Code is required";
        } elseif ($code == '173') {
            return "Payment method is not enabled";
        } elseif ($code == '174') {
            return "Card Number is required";
        } elseif ($code == '175') {
            return "EAN is required";
        } elseif ($code == '176') {
            return "Payment Currency is not supported";
        } elseif ($code == '177') {
            return "Card Number is invalid";
        } elseif ($code == '178') {
            return "EAN is invalid";
        } elseif ($code == '179') {
            return "The max number of installments allowed for recurring payment is 1";
        } elseif ($code == '180') {
            return "The provided Card PaymentToken was not found";
        } elseif ($code == '181') {
            return "The MerchantIdJustClick is not configured";
        } elseif ($code == '182') {
            return "Brand is required";
        } elseif ($code == '183') {
            return "Invalid customer bithdate";
        } elseif ($code == '184') {
            return "Request could not be empty";
        } elseif ($code == '185') {
            return "Brand is not supported by selected provider";
        } elseif ($code == '186') {
            return "The selected provider does not support the options provided (Capture, Authenticate, Recurrent or Installments)";
        } elseif ($code == '187') {
            return "ExtraData Collection contains one or more duplicated names";
        } elseif ($code == '188') {
            return "Avs with CPF invalid";
        } elseif ($code == '189') {
            return "Avs with length of street exceeded";
        } elseif ($code == '190') {
            return "Avs with length of number exceeded";
        } elseif ($code == '191') {
            return "Avs with length of district exceeded";
        } elseif ($code == '192') {
            return "Avs with zip code invalid";
        } elseif ($code == '193') {
            return "Split Amount must be greater than zero";
        } elseif ($code == '194') {
            return "Split Establishment is Required";
        } elseif ($code == '195') {
            return "The PlataformId is required";
        } elseif ($code == '196') {
            return "DeliveryAddress is required";
        } elseif ($code == '197') {
            return "Street is required";
        } elseif ($code == '198') {
            return "Number is required";
        } elseif ($code == '199') {
            return "ZipCode is required";
        } elseif ($code == '200') {
            return "City is required";
        } elseif ($code == '201') {
            return "State is required";
        } elseif ($code == '202') {
            return "District is required";
        } elseif ($code == '203') {
            return "Cart item Name is required";
        } elseif ($code == '204') {
            return "Cart item Quantity is required";
        } elseif ($code == '205') {
            return "Cart item type is required";
        } elseif ($code == '206') {
            return "Cart item name length exceeded";
        } elseif ($code == '207') {
            return "Cart item description length exceeded";
        } elseif ($code == '208') {
            return "Cart item sku length exceeded";
        } elseif ($code == '209') {
            return "Shipping addressee sku length exceeded";
        } elseif ($code == '210') {
            return "Shipping data cannot be null";
        } elseif ($code == '211') {
            return "WalletKey is invalid";
        } elseif ($code == '212') {
            return "Merchant Wallet Configuration not found";
        } elseif ($code == '213') {
            return "Credit Card Number is invalid";
        } elseif ($code == '214') {
            return "Credit Card Holder Must Have Only Letters";
        } elseif ($code == '215') {
            return "Agency is required in Boleto Credential";
        } elseif ($code == '216') {
            return "Customer IP address is invalid";
        } elseif ($code == '300') {
            return "MerchantId was not found";
        } elseif ($code == '301') {
            return "Request IP is not allowed";
        } elseif ($code == '302') {
            return "Sent MerchantOrderId is duplicated";
        } elseif ($code == '303') {
            return "Sent OrderId does not exist";
        } elseif ($code == '304') {
            return "Customer Identity is required";
        } elseif ($code == '306') {
            return "Merchant is blocked";
        } elseif ($code == '307') {
            return "Transaction not found";
        } elseif ($code == '308') {
            return "Transaction not available to capture";
        } elseif ($code == '309') {
            return "Transaction not available to void";
        } elseif ($code == '310') {
            return "Payment method doest not support this operation";
        } elseif ($code == '311') {
            return "Refund is not enabled for this merchant";
        } elseif ($code == '312') {
            return "Transaction not available to refund";
        } elseif ($code == '313') {
            return "Recurrent Payment not found";
        } elseif ($code == '314') {
            return "Invalid Integration";
        } elseif ($code == '315') {
            return "Cannot change NextRecurrency with pending paymentn";
        } elseif ($code == '316') {
             "Cannot set NextRecurrency to past date";
        } elseif ($code == '317') {
            return "Invalid Recurrency Day";
        } elseif ($code == '318') {
            return "No transaction found";
        } elseif ($code == '319') {
            return "Smart recurrency is not enabled";
        } elseif ($code == '320') {
            return "Can not Update Affiliation Because this Recurrency not Affiliation saved";
        } elseif ($code == '321') {
            return "Can not set EndDate to before next recurrency";
        } elseif ($code == '322') {
            return "Zero Dollar Auth is not enabled";
        } elseif ($code == '323') {
            return "Bin Query is not enabled";
        } else {
            return "Erro não catalogado code: " . $code;
        }
    }

}
