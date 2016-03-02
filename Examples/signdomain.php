<?php
require('../autoloader.php');


try {
    $domainname = 'dnssectest.nl';
    // Please enter your own settings file here under before using this example
    if ($conn = Metaregistrar\EPP\eppConnection::create('')) {
        $conn->enableDnssec();
        if ($conn->login()) {
            $add = new Metaregistrar\EPP\eppDomain($domainname);
            $sec = new Metaregistrar\EPP\eppSecdns();
            $sec->setKey('256', '8', 'AwEAAbWM8nWQZbDZgJjyq+tLZwPLEXfZZjfvlRcmoAVZHgZJCPn/Ytu/iOsgci+yWgDT28ENzREAoAbKMflFFdhc5DNV27TZxhv8nMo9n2f+cyyRKbQ6oIAvMl7siT6WxrLxEBIMyoyFgDMbqGScn9k19Ppa8fwnpJgv0VUemfxGqHH9');
            $add->addSecdns($sec);
            $domain = new Metaregistrar\EPP\eppDnssecUpdateDomainRequest($domainname, $add);
            if ((($response = $conn->writeandread($domain)) instanceof Metaregistrar\EPP\eppUpdateDomainResponse) && ($response->Success())) {
                /* @var $response Metaregistrar\EPP\eppUpdateDomainResponse */
                echo "OKAY\n";
            }
            $conn->logout();
        }
    }
} catch (Metaregistrar\EPP\eppException $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

