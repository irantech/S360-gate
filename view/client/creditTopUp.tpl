{load_presentation_object filename="paymentsPayStar" assign="objbank"}
{assign var="price" value=$smarty.post.price}
{assign var="clientID" value=$smarty.post.clientID}
{assign var="operation" value=$smarty.post.operation}
{assign var="bankPayStar" value=$objbank->initiatePaystarPayment($price,$clientID,$operation)}
