#!/bin/bash

    usage="$(basename $0) [-h] MODULE_TYPE MODULE_NAME  -- CREATE MODELS FOR PFF

    where:
        -h  show this help text

    MODEL_TYPE:

        single      table with 1 array collection ( news + n image for news )
        single2     table with 2 array collection ( blog articles + n image for article + n comments for article)
        multi       table whit 1 array collection in multi language ( news with multi language text + n image for news in multilanguage )

     MODEL_NAME

        write the name of the new class all in lower case.

                ";

    while getopts ':h' option; do
      case "$option" in
        h) echo "$usage"
           exit
           ;;
        ?) printf "illegal option: '%s'\n" "$OPTARG" >&2
           echo "$usage" >&2
           exit 1
           ;;
      esac
    done

    shift $((OPTIND - 1))

   if [[ $# -ne 2 ]]

   then

   echo "$usage"
   exit 1

   fi

   MTYPE=$1;
   MODULE1=$2;
   MODULE2=`echo "${MODULE1:0:1}" | tr "[:lower:]" "[:upper:]" ``echo "${MODULE1:1}"`;

      case "$MTYPE" in
        single)     ./module_single.sh $MODULE1 $MODULE2
                    echo 'Fine della creazione';
                    exit
                    ;;
        single2)    ./module_single2.sh $MODULE1 $MODULE2
                    echo 'Fine della creazione';
                    exit
                    ;;
        multi)      ./module_multi.sh $MODULE1 $MODULE2
                    echo 'Fine della creazione';
                    exit
                    ;;
        *)          printf "illegal option: '%s'\n" "$OPTARG" >&2
                    echo "$usage" >&2
                    exit 1
                    ;;
      esac



