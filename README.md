# Greenhouse Project Back-end

## Setting up back-end
Project API

## API Map, 'Tag Edition' (aka "You are here")

**index.php**: Parse URL, select the route file, pass method + id.
_"blabla get food blabla"_

**routes/tags.php**: Catch HTTP method and call the right controller
_"Get food? Okay! So no sport shop, no hairdresser... Here, let's call a restaurant!"_

**controllers/TagController.php**: Business logic, order pass to the model.
_"Welcome! What would you like to order?"_

**models/Tag.php**: Contains SQL and call the DB, returns a TagEntity objects.
_"Hey Chef, one lunch menu gyozas and vegetables with a large mango boba tea"_

**entities/Tag.php**: Defines the data shape.
_"You KNOW Gyozas are 6 pieces, vegetable one middle size plate, large boba is 700ml"_
