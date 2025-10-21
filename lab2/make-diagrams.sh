#!/bin/bash

# from root directory
# make diagram folder
mkdir -p patterns/diagrams

# Singleton
vendor/bin/php-class-diagram patterns/singleton > patterns/diagrams/singleton.puml

# Factory
vendor/bin/php-class-diagram patterns/factory > patterns/diagrams/factory.puml

# MVC
vendor/bin/php-class-diagram patterns/mvc > patterns/diagrams/mvc.puml