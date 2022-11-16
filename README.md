##
The `CloneAbleUser` class allows to create a clone of the object including array of the objects of the same type and allows cross references.

## Usage
```
$rick = new CloneAbleUser(1, 'Rick', []);
$martin = new CloneAbleUser(2, 'Martin', []);

// Make cross refs
$rick->addFriend($martin);
$martin->addFriend($rick);

$anotherRick = $rick->clone();
```

## Installation

### Clone Repository
```
git clone https://github.com/scherbakovandrey/Cloner.git
cd Cloner
```

### Install Dependencies and assets
```
composer install
```

# Tests

## Run Tests locally
Execute the tests locally with:
```
./vendor/bin/phpunit
```

