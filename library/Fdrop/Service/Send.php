<?php
/**
 *
 **/
class Fdrop_Service_Send
{
    const URL='http://fdrop.it';

    private function setNamespace($dom)
    {
        $dom->registerXPathNamespace('x', 'http://www.w3.org/1999/xhtml');
        return $dom;
    }

    private function getFormAttributes($dom)
    {
        $form = $this->setNamespace($dom)->xpath('//x:form');

        return array(
            'action' => (string) $form[0]->attributes()->action,
            'method' => (string) $form[0]->attributes()->method
        );
    }

    private function getFileInputName($dom)
    {
        $element = $this->setNamespace($dom)->xpath('//x:form/x:input[@type="file"]/@name');

        return array(
            'param' => (string) $element[0]
        );
    }

    private function makeRequest(Zend_Http_Client $client)
    {
        $client->setHeaders(array('Accept' => 'application/xhtml+xml'));
        return simplexml_load_string($client->request()->getBody());
    }

    protected function getSendFileInfo()
    {
        $dom = $this->makeRequest(new Zend_Http_Client(self::URL));

        return array_merge(
            $this->getFormAttributes($dom),
            $this->getFileInputName($dom)
        );
    }

    public function fdrop($file)
    {
        $info = $this->getSendFileInfo();

        $client = new Zend_Http_Client(self::URL."/{$info['action']}");
        $client->setMethod($info['method'])->setFileUpload($file, $info['param']);
        $client->setConfig(array('timeout' => -1));

        $links = $this->setNamespace($this->makeRequest($client))->xpath('//x:a[@rel="drop"]');

        return array(
            'drop' => $links[0]->attributes()->href
        );
    }
}

