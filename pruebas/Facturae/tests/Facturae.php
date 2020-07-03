<?php
//use josemmo\Facturae\Facturae;
//use josemmo\Facturae\FacturaeItem;
//use josemmo\Facturae\FacturaeParty;
//use PHPUnit\Framework\TestCase;
require_once "../src/Facturae.php";
require_once "../src/FacturaeParty.php";
require_once "../src/FacturaeCentre.php";
require_once "../src/FacturaeItem.php";
// Creamos la factura
$fac = new Facturae();

// Asignamos el número EMP2017120003 a la factura
// Nótese que Facturae debe recibir el lote y el
// número separados
$fac->setNumber('EMP201712', '0003');

// Asignamos el 01/12/2017 como fecha de la facturasetIssueDate
$fac->setIssueDate('2017-12-01');

// Incluimos los datos del vendedor
$fac->setSeller(new FacturaeParty([
    "taxNumber" => "A00000000",
    "name"      => "Perico el de los Palotes S.A.",
    "address"   => "C/ Falsa, 123",
    "postCode"  => "123456",
    "town"      => "Madrid",
    "province"  => "Madrid"
]))  ;

// Incluimos los datos del comprador
// Con finos demostrativos el comprador será
// una persona física en vez de una empresa

$ayto = new FacturaeParty([
    "taxNumber" => "P2813400E",
    "name"      => "Ayuntamiento de San Sebastián de los Reyes",
    "address"   => "Plaza de la Constitución, 1",
    "postCode"  => "28701",
    "town"      => "San Sebastián de los Reyes",
    "province"  => "Madrid",
    "centres"   => [
        new FacturaeCentre([
            "role"     => FacturaeCentre::ROLE_GESTOR,
            "code"     => "L01281343",
            "name"     => "Intervención Municipal",
            "address"  => "Plaza de la Constitución, 1",
            "postCode" => "28701",
            "town"     => "San Sebastián de los Reyes",
            "province" => "Madrid"
        ]),
        new FacturaeCentre([
            "role"     => FacturaeCentre::ROLE_TRAMITADOR,
            "code"     => "L01281343",
            "name"     => "Intervención Municipal",
            "address"  => "Plaza de la Constitución, 1",
            "postCode" => "28701",
            "town"     => "San Sebastián de los Reyes",
            "province" => "Madrid"
        ]),
        new FacturaeCentre([
            "role"     => FacturaeCentre::ROLE_CONTABLE,
            "code"     => "L01281343",
            "name"     => "Intervención Municipal",
            "address"  => "Plaza de la Constitución, 1",
            "postCode" => "28701",
            "town"     => "San Sebastián de los Reyes",
            "province" => "Madrid"
        ])
    ]
]);

$fac->setBuyer($ayto) ;

//$fac->setBuyer(new FacturaeParty([
//    "isLegalEntity" => false,       // Importante!
//    "taxNumber"     => "00000000A",
//    "name"          => "Antonio",
//    "firstSurname"  => "García",
//    "lastSurname"   => "Pérez",
//    "address"       => "Avda. Mayor, 7",
//    "postCode"      => "654321",
//    "town"          => "Madrid",
//    "province"      => "Madrid"
//]));

// Añadimos los productos a incluir en la factura
// En este caso, probaremos con tres lámpara por
// precio unitario de 20,14€ con 21% de IVA ya incluído
$fac->addItem("Lámpara de pie", 20.14, 3, Facturae::TAX_IVA, 21);

// Ya solo queda firmar la factura ...
$fac->sign(
    "public.pem",
    "private.pem",
    "passphrase"
);

// ... y exportarlo a un archivo
$fac->export("salida.xsig");

?>