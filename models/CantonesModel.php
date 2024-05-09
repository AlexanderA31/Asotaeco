<?php

class CantonesModel
{


    private $ecuadorData = [
        'Azuay' => ['Cuenca', 'Gualaceo', 'Paute', 'Sigsig', 'Santa Isabel', 'Chordeleg', 'Girón', 'Guachapala', 'Camilo Ponce Enríquez', 'Nabón', 'Oña', 'Pucará', 'San Fernando', 'Sevilla de Oro'],
        'Bolívar' => ['Guaranda', 'Chillanes', 'Chimbo', 'Echeandía', 'Caluma', 'San Miguel', 'Las Naves'],
        'Cañar' => ['Azogues', 'Déleg', 'La Troncal', 'El Tambo', 'Suscal', 'Cañar', 'Biblián', 'Honorato Vázquez', 'Simón Bolívar', 'Chorocopte', 'Juncal'],
        'Carchi' => ['Tulcán', 'Bolívar', 'Espejo', 'Mira', 'Montúfar', 'San Pedro de Huaca', 'El Ángel'],
        'Chimborazo' => ['Riobamba', 'Alausí', 'Chambo', 'Chunchi', 'Colta', 'Cumandá', 'Guano', 'Guamote', 'Pallatanga', 'Penipe'],
        'Cotopaxi' => ['Latacunga', 'La Maná', 'Pangua', 'Pujilí', 'Salcedo', 'Saquisilí', 'Sigchos'],
        'El Oro' => ['Machala', 'Arenillas', 'Atahualpa', 'Balsas', 'Chilla', 'El Guabo', 'Huaquillas', 'Las Lajas', 'Marcabelí', 'Pasaje', 'Piñas', 'Portovelo', 'Santa Rosa', 'Zaruma'],
        'Esmeraldas' => ['Esmeraldas', 'Eloy Alfaro', 'Muisne', 'Quinindé', 'San Lorenzo', 'Atacames', 'Rioverde', 'La Concordia'],
        'Galápagos' => ['San Cristóbal', 'Isabela', 'Santa Cruz'],
        'Guayas' => ['Guayaquil', 'Alfredo Baquerizo Moreno', 'Balao', 'Balzar', 'Colimes', 'Daule', 'Durán', 'El Empalme', 'El Triunfo', 'Milagro', 'Naranjal', 'Naranjito', 'Palestina', 'Pedro Carbo', 'Samborondón', 'Santa Lucía', 'Salitre', 'General Antonio Elizalde', 'Isidro Ayora', 'Lomas de Sargentillo', 'Nobol', 'Playas', 'Simón Bolívar', 'Coronel Marcelino Maridueña', 'Yaguachi', 'Yaguachi Nuevo', 'El Triunfo'],
        'Imbabura' => ['Ibarra', 'Antonio Ante', 'Cotacachi', 'Otavalo', 'Pimampiro', 'San Miguel de Urcuquí'],
        'Loja' => ['Loja', 'Calvas', 'Catamayo', 'Celica', 'Chaguarpamba', 'Espíndola', 'Gonzanamá', 'Macará', 'Paltas', 'Puyango', 'Olmedo', 'SaragUro', 'Sozoranga', 'Zapotillo', 'Pindal', 'Quilanga', 'Saraguro'],
        'Los Ríos' => ['Babahoyo', 'Baba', 'Buena Fé', 'Mocache', 'Montalvo', 'Puebloviejo', 'Quevedo', 'Urdaneta', 'Valencia', 'Ventanas', 'Vinces', 'Palenque', 'Catarama'],
        'Manabí' => ['Portoviejo', 'Bolívar', 'Chone', 'El Carmen', 'Flavio Alfaro', 'Jama', 'Jaramijó', '24 de Mayo', 'Sucre', 'Pedernales', 'Olmedo', 'Puerto López', 'Jipijapa', 'Montecristi', 'Pajan', 'Pichincha', 'Rocafuerte', 'Santa Ana', 'Sucre', 'Tosagua', 'Manta', 'Portoviejo', 'San Vicente'],
        'Morona Santiago' => ['Macas', 'Gualaquiza', 'Huamboya', 'Limón Indanza', 'Logroño', 'Morona', 'Pablo Sexto', 'Palora', 'San Juan Bosco', 'Taisha', 'Tiwintza'],
        'Napo' => ['Tena', 'Archidona', 'El Chaco', 'Quijos', 'Carlos Julio Arosemena Tola'],
        'Orellana' => ['Francisco de Orellana', 'Aguarico', 'La Joya de los Sachas', 'Loreto'],
        'Pastaza' => ['Pastaza', 'Arajuno', 'Mera', 'Santa Clara'],
        'Pichincha' => ['Quito', 'Cayambe', 'Mejía', 'Pedro Moncayo', 'Rumiñahui', 'San Miguel de los Bancos', 'Pedro Vicente Maldonado', 'Puerto Quito'],
        'Santa Elena' => ['Santa Elena', 'La Libertad', 'Salinas', 'Ancón'],
        'Santo Domingo de los Tsáchilas' => ['Santo Domingo', 'La Concordia'],
        'Sucumbíos' => ['Nueva Loja', 'Gonzalo Pizarro', 'Lago Agrio', 'Putumayo', 'Shushufindi', 'Sucumbíos', 'Cascales', 'Cuyabeno'],
        'Tungurahua' => ['Ambato', 'Baños de Agua Santa', 'Cevallos', 'Mocha', 'Patate', 'Pelileo', 'Píllaro', 'Quero', 'San Pedro de Pelileo', 'Santiago de Píllaro', 'Tisaleo'],
        'Zamora Chinchipe' => ['Zamora', 'Chinchipe', 'Nangaritza', 'Yacuambi', 'Yantzaza', 'El Pangui', 'Centinela del Cóndor', 'Paquisha', 'Yanzatza', 'El Pangui']
    ];


    // Obtener todos los cantones de una provincia específica
    function getCantonsByProvince($province)
    {
        return isset($this->ecuadorData[$province]) ? $this->ecuadorData[$province] : [];
    }

    //Obtener todas las provincias de Ecuador
    function getAllProvinces()
    {
        return array_keys($this->ecuadorData);
    }
}
