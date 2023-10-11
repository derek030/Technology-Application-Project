import { createClient } from '@supabase/supabase-js'

const supabaseUrl = process.env.supabase.url
const supabaseKey = process.env.supabase_key
const supabase = createClient(supabaseUrl, supabaseKey)
