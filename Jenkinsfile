pipeline {
    agent any

    environment {
        TELEGRAM_TOKEN = credentials('TOKEN')
        CHAT_ID    = credentials('Chat_ID')
    }

    stages {
         stage('Deploy') {
            steps {
                 sh 'ssh -o StrictHostKeyChecking=no root@157.245.193.126 " cd ~/knk/api/;\
                git pull;\
                cd ..;\
                docker-compose up -d;\
                "'
            }
        }
       
    }
    post{
        success{

            sh ''' 
            sh 1-success-dev.sh;\
            '''
        }
        failure{
            sh ''' 
            sh 2-fail-dev.sh;\
            '''
        }
    }
}
