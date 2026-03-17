pipeline {
    agent any

    environment {
        APP_NAME    = 'isi-burger'
        DOCKER_IMAGE = "isi-burger:${env.BUILD_NUMBER}"
    }

    stages {

        // ── 1. Pull du code ──────────────────────────
        stage('Pull du code') {
            steps {
                echo 'Récupération du code depuis GitHub...'
                checkout scm
            }
        }

        // ── 2. Installation des dépendances ──────────
        stage('Installation Laravel') {
            steps {
                echo 'Installation des dépendances Composer...'
                sh 'composer install --no-interaction --prefer-dist --optimize-autoloader'

                echo 'Installation des dépendances Node...'
                sh 'npm ci'

                echo 'Configuration .env...'
                sh '''
                    cp .env.example .env
                    php artisan key:generate
                '''
            }
        }

        // ── 3. Build Frontend ─────────────────────────
        stage('Build Frontend') {
            steps {
                echo 'Compilation des assets...'
                sh 'npm run build'
            }
        }

        // ── 4. Migration ──────────────────────────────
        stage('Migration Base de données') {
            steps {
                echo '🗄️ Migration de la base de données...'
                sh 'php artisan migrate --force'
                sh 'php artisan db:seed --force'
            }
        }

        // ── 5. Build Docker ───────────────────────────
        stage('Build Image Docker') {
            steps {
                echo 'Construction de l\'image Docker...'
                sh "docker build -t ${DOCKER_IMAGE} ."
                sh "docker tag ${DOCKER_IMAGE} isi-burger:latest"
            }
        }

        // ── 6. Deploy ─────────────────────────────────
        stage('Déploiement') {
            steps {
                echo 'Déploiement du container...'
                sh '''
                    docker stop isi-burger-app || true
                    docker rm   isi-burger-app || true
                    docker run -d \
                        --name isi-burger-app \
                        --network isi-burger_default \
                        -p 8000:8000 \
                        -e DB_HOST=db \
                        -e DB_PORT=5432 \
                        -e DB_DATABASE=laravel \
                        -e DB_USERNAME=laravel \
                        -e DB_PASSWORD=laravel \
                        isi-burger:latest
                '''
            }
        }
    }

    post {
        success {
            echo 'Pipeline terminé avec succès !'
        }
        failure {
            echo 'Echec du pipeline.'
        }
    }
}
