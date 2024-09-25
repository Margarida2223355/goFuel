#!/bin/bash
php yii migrate/fresh --interactive=0
php yii migrate --migrationPath=@yii/rbac/migrations --interactive=0
php yii migrate --interactive=0